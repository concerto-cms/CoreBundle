<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 21:43
 */

namespace ConcertoCms\CoreBundle\Command;


use ConcertoCms\CoreBundle\Document\Page;
use ConcertoCms\CoreBundle\Model\Locale;
use ConcertoCms\CoreBundle\Service\Content;
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
        /**
         * @var $cm Content
         */
        $cm = $this->getContainer()->get("concerto_cms_core.content");

        // English homepage
        $page = new Page();
        $page->setTitle("Hello world");
        $language = new Locale("en-UK", "English", "en");
        $cm->addLanguage($language, $page);

        // Dutch homepage
        $page = new Page();
        $page->setTitle("Hallo, wereld");
        $language = new Locale("nl-BE", "Nederlands", "nl");
        $cm->addLanguage($language, $page);

        $page = new Page();
        $page->setTitle("Hello world");
        $language = new Locale("fr-BE", "Français", "fr");
        $cm->addLanguage($language, $page);


        $page = new Page();
        $page->setTitle("Meet the company");
        $page->setSlug("company");
        $cm->createPage("/en", $page);

        $page = new Page();
        $page->setTitle("Meet the sales team");
        $page->setSlug("team");
        $cm->createPage("/en/company", $page);

        $page = new Page();
        $page->setTitle("Drop us a line");
        $page->setSlug("contact");
        $cm->createPage("/en/company", $page);

        // Splash page is not supported yet...
        //$cm->setSplash(Content::SPLASH_MODE_REDIRECT, "/en");





    }
}
