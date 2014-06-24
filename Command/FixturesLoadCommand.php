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
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;

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
        $nm = $this->getContainer()->get('concerto_cms_core.navigation');

        // English homepage
        $page = new Page();
        $page->setTitle("Hello world");
        $page->setContent(file_get_contents("http://loripsum.net/api"));
        $language = new Locale("en-UK", "English", "en");
        $cm->addLanguage($language, $page);
        $cm->flush();
        $cm->clear();

        // Create the main menu
        $menu = new Menu();
        $menu->setName("main-menu");
        $menu->setLabel("Main menu");
        $nm->addMenu($menu);
        $cm->flush();
        $cm->clear();

        $route = $cm->getRoute("en");
        $item = new MenuNode();
        $item->setLabel("Home");
        $item->setName("home");
        $item->setContent($route);
        $nm->addMenuItem("main-menu", "en", "", $item);

        // Dutch homepage
        $page = new Page();
        $page->setTitle("Hallo, wereld");
        $page->setContent(file_get_contents("http://loripsum.net/api"));
        $language = new Locale("nl-BE", "Nederlands", "nl");
        $cm->addLanguage($language, $page);

        $page = new Page();
        $page->setTitle("Hello world");
        $language = new Locale("fr-BE", "Français", "fr");
        $cm->addLanguage($language, $page);

        $route = $cm->createPage(
            "/en",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "company",
                "title" => "Meet the company",
                "content" => file_get_contents("http://loripsum.net/api")
            )
        );

        $item = new MenuNode();
        $item->setLabel("Company");
        $item->setName("company");
        $item->setContent($route);
        $nm->addMenuItem("main-menu", "en", "/", $item);

        $route = $cm->createPage(
            "/en/company",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "team",
                "title" => "Meet the sales team",
                "content" => file_get_contents("http://loripsum.net/api")
            )
        );
        $item = new MenuNode();
        $item->setLabel("Sales");
        $item->setName("sales");
        $item->setContent($route);
        $nm->addMenuItem("main-menu", "en", "company", $item);

        $route = $cm->createPage(
            "/en",
            "ConcertoCmsCoreBundle:Page",
            array(
                "slug" => "contact",
                "title" => "Drop us a line",
                "content" => file_get_contents("http://loripsum.net/api")
            )
        );

        $item = new MenuNode();
        $item->setLabel("Contact");
        $item->setName("contact");
        $item->setContent($route);
        $nm->addMenuItem("main-menu", "en", "/", $item);

        // Splash page is not supported yet...
        //$cm->setSplash(Content::SPLASH_MODE_REDIRECT, "/en");

        $cm->flush();
    }
}
