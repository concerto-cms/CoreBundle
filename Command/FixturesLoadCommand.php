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


        $cm->createPage(
            "/en",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "company",
                "title" => "Meet the company"
            )
        );

        $cm->createPage(
            "/en/company",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "team",
                "title" => "Meet the sales team"
            )
        );

        $cm->createPage(
            "/en",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "contact",
                "title" => "Drop us a line"
            )
        );

        // Splash page is not supported yet...
        //$cm->setSplash(Content::SPLASH_MODE_REDIRECT, "/en");

        $cm->flush();
        $cm->clear();
    }
}
