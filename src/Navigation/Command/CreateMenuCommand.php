<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Navigation\Command;

use ConcertoCms\CoreBundle\Navigation\Service\NavigationManager;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Provider\PhpcrMenuProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMenuCommand extends ContainerAwareCommand
{
    private $nm;
    public function __construct(NavigationManager $nm)
    {
        parent::__construct();
        $this->nm = $nm;
    }

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
         * @var $cm NavigationManager
         */

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
        $this->nm->addMenu($menu);
        $this->nm->flush();

        $output->writeln("Menu was created successfully!");
    }
}
