<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Command;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Provider\PhpcrMenuProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ConcertoCms\CoreBundle\Document\Page;
use ConcertoCms\CoreBundle\Model\Locale;
use ConcertoCms\CoreBundle\Service\Content;

class CreateMenuItemCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName("concerto:create:menuitem")
            ->setDescription("Add the menus");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var $provider PhpcrMenuProvider
         * @var $dm \Doctrine\ODM\PHPCR\DocumentManager
         * @var $dialog DialogHelper
         */
        $provider =  $this->getContainer()->get("cmf_menu.provider");
        $dm = $this->getContainer()->get("doctrine_phpcr.odm.default_document_manager");
        $dialog = $this->getHelperSet()->get('dialog');


        $menuName = $dialog->ask(
            $output,
            'Please enter the name (id) of the target menu [main-menu]:  ',
            'main-menu'
        );


        $menuName = $provider->getMenuRoot() . "/" . $menuName;
        $menu = $dm->find(null, $menuName);

        if (!$menu)
        {
            $output->writeln("The menu you entered does not exist!");
            die();
        }

        $parentName = $dialog->ask(
            $output,
            'Please enter the path of the parent menu [/]:  ',
            '/'
        );

        if ($parentName == "/")
            $parentName = "";
        $parentName = $menuName . $parentName;
        $parent = $dm->find(null, $parentName);

        if (!$parent)
        {
            $output->writeln("The menu you entered ( ". $parentName . ") does not exist!");
            die();
        }


        $itemName = $dialog->ask(
            $output,
            'Please enter the name (id) of the menu item [home]:  ',
            'home'
        );

        $itemLabel = $dialog->ask(
            $output,
            'Please enter the label of the menu [Home]:  ',
            'Home'
        );

        $itemUrl = $dialog->ask(
            $output,
            'Please enter the url of the target page [#]:  ',
            '#'
        );
        $item = new MenuNode();
        $item->setName($itemName);
        $item->setLabel($itemLabel);
        $item->setParent($parent);

        $page = $dm->find(null, "/cms/routes" . $itemUrl);
        if ($page) {
            $item->setContent($page);
        } else {
            $item->setUri($itemUrl);
        }

        $dm->persist($item);

        $dm->flush();
        $output->writeln("Menu was created successfully!");
    }

} 