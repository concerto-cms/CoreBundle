<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 21:43
 */

namespace ConcertoCms\CoreBundle\Util\Command;


use ConcertoCms\CoreBundle\Document\SimplePage;
use ConcertoCms\CoreBundle\Languages\Model\Locale;
use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;

class FixturesLoadCommand extends ContainerAwareCommand
{
    private $pm;
    private $lm;

    public function __construct(PagesManager $pm, LanguagesManager $lm)
    {
        parent::__construct();
        $this->pm = $pm;
        $this->lm = $lm;
    }
    protected function configure()
    {
        $this
            ->setName("concerto:fixtures:load")
            ->setDescription("Add a few demo pages");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // English homepage
        $page = new SimplePage();
        $page->setTitle("Hello world");
        $page->setContent(file_get_contents("http://loripsum.net/api"));
        $language = new Locale("en-UK", "English", "en");
        $this->lm->addLocale($language, $page);
        $this->lm->flush();
        $this->lm->clear();

        // Dutch homepage
        $page = new SimplePage();
        $page->setTitle("Hallo, wereld");
        $page->setContent(file_get_contents("http://loripsum.net/api"));
        $language = new Locale("nl-BE", "Nederlands", "nl");
        $this->lm->addLocale($language, $page);
        $this->lm->flush();
        $this->lm->clear();

        // French homepage
        $page = new SimplePage();
        $page->setTitle("Hello world");
        $language = new Locale("fr-BE", "Français", "fr");
        $this->lm->addLocale($language, $page);
        $this->lm->flush();
        $this->lm->clear();

        $this->pm->createPage("/en", "simplepage", [
                "slug" => "company",
                "title" => "Meet the company",
                "content" => file_get_contents("http://loripsum.net/api")
            ]);
        $this->pm->flush();
        $this->pm->clear();

        $this->pm->createPage("/en/company", "simplepage", [
                "slug" => "team",
                "title" => "Meet the sales team",
                "content" => file_get_contents("http://loripsum.net/api")
            ]);
        $this->pm->flush();
        $this->pm->clear();

        $this->pm->createPage("/en", "simplepage", [
                "slug" => "contact",
                "title" => "Drop us a line",
                "content" => file_get_contents("http://loripsum.net/api")
            ]);
        $this->pm->flush();
        $this->pm->clear();
    }
}
