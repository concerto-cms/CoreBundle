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

class SyncLanguagesCommand extends ContainerAwareCommand
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
            ->setName("concerto:sync:menu")
            ->setDescription("Synchronize languages with navigation");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->nm->syncLanguages();
        $output->writeln("Syncing complete");
    }
}
