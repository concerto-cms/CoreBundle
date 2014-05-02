<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Command;

use ConcertoCms\CoreBundle\Service\Navigation;
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

class CreateMenuItemCommand extends ContainerAwareCommand
{
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
         * @var $dialog DialogHelper
         * @var $cm Navigation
         * @var $contentService Content
         */
        $contentService = $this->getContainer()->get("concerto_cms_core.content");
        $cm = $this->getContainer()->get("concerto_cms_core.navigation");
        $provider =  $this->getContainer()->get("cmf_menu.provider");
        $dialog = $this->getHelperSet()->get('dialog');


        $menuName = $dialog->ask(
            $output,
            'Please enter the name (id) of the target menu [main-menu]:  ',
            'main-menu'
        );

        $locale = $dialog->ask(
            $output,
            'Please enter the locale menu item [en]:  ',
            'en'
        );


        $menu = $cm->getMenuLocale($menuName, $locale);
        if (!$menu) {
            $output->writeln("The menu you entered does not exist!");
            die();
        }

        $parentName = $dialog->ask(
            $output,
            'Please enter the path of the parent menu []:  ',
            ''
        );

        if ($parentName == "/") {
            $parentName = "";
        }
        $parent = $cm->getMenu($menuName . "/" . $locale . $parentName);

        if (!$parent) {
            $output->writeln(
                "The menu you entered ( ". $menuName . "/" . $locale . "/" . $parentName . ") does not exist!"
            );
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

        $page = $contentService->getRoute($itemUrl);
        if ($page) {
            $item->setContent($page);
        } else {
            $item->setUri($itemUrl);
        }

        $cm->addMenuItem($menuName, $locale, $parentName, $item);

        $output->writeln("Menu was created successfully!");
    }
}
