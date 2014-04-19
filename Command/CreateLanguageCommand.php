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

class CreateLanguageCommand extends ContainerAwareCommand {
    protected function configure()
    {
        $this
            ->setName("concerto:create:language")
            ->setDescription("Add a language");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var $cm Content
         * @var $dialog DialogHelper
         */
        $cm = $this->getContainer()->get("concerto_cms_core.content");
        $dialog = $this->getHelperSet()->get('dialog');

        $language = new Locale(
            $dialog->ask(
                $output,
                'Please enter the language ISO code [en-UK]:  ',
                'en-UK'
            ),
            $dialog->ask(
                $output,
                'Please enter the full name of the homepage [English]:  ',
                'English'
            ), $dialog->ask(
                $output,
                'Please provide a URL prefix [en]:  ',
                'en'
            ));

        $page = new Page();
        $page->setTitle("");

        $cm->addLanguage($language, $page);

        $output->writeln("Language was created successfully!");
    }

} 