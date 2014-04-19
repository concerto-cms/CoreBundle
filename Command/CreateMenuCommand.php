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

class CreateMenuCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName("concerto:create:menu")
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

        $menuParent = $dm->find(null, $provider->getMenuRoot());
        if (!$menuParent)
        {
            $output->writeln("MenuBundle has not yet been initialized! Please run doctrine:phpcr:repository:init first!");
            die();
        }

        $name = $dialog->ask(
            $output,
            'Please enter the name (id) of the menu [main-menu]:  ',
            'main-menu'
        );
        $label = $dialog->ask(
            $output,
            'Please enter the label of the menu [Main menu]:  ',
            'Main menu'
        );

        $main = new Menu();
        $main->setName($name);
        $main->setLabel($label);
        $main->setLocale("en");
        $main->setParent($menuParent);
        $dm->persist($main);

        $dm->flush();
        $output->writeln("Menu was created successfully!");
    }

} 