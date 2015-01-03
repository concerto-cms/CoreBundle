<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Navigation\Command;

use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Provider\PhpcrMenuProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ConcertoCms\CoreBundle\Navigation\Service\NavigationManager;
use Symfony\Component\Console\Helper\DialogHelper;

class CreateMenuItemCommand extends Command
{
    private $nm;
    private $rm;

    public function __construct(NavigationManager $nm, RoutesManager $rm)
    {
        parent::__construct();
        $this->nm = $nm;
        $this->rm = $rm;
    }

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

        //$provider =  $this->getContainer()->get("cmf_menu.provider");
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


        $menu = $this->nm->getMenu($menuName, $locale);
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
        $parent = $this->nm->getMenu($menuName . "/" . $locale . "/" . $parentName);

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

        $page = $this->rm->getByUrl($itemUrl);
        if ($page) {
            $item->setContent($page);
        } else {
            $item->setUri($itemUrl);
        }
        $this->nm->addMenuItem($menuName, $locale, $parentName, $item);
        $this->nm->flush();
        $output->writeln("Menu was created successfully!");
    }
}
