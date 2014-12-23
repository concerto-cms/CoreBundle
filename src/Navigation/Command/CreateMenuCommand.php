<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Navigation\Command;

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

class CreateMenuCommand extends ContainerAwareCommand
{
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
         * @var $dialog DialogHelper
         * @var $cm Navigation
         */
        $cm = $this->getContainer()->get("concerto_cms_core.navigation");
        //$provider =  $this->getContainer()->get("cmf_menu.provider");
        $dialog = $this->getHelperSet()->get('dialog');

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

        $menu = new Menu();
        $menu->setName($name);
        $menu->setLabel($label);
        $cm->addMenu($menu);

        $output->writeln("Menu was created successfully!");
    }
}
