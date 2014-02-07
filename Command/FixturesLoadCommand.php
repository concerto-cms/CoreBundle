<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 21:43
 */

namespace ConcertoCms\CoreBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixturesLoadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("concerto:fixtures:load")
            ->setDescription("Add a few demo pages");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
