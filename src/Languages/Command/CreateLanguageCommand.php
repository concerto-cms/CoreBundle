<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Languages\Command;

use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use ConcertoCms\CoreBundle\Languages\Model\Locale;
use ConcertoCms\CoreBundle\Document\SimplePage;
use ConcertoCms\CoreBundle\Pages\Service\PageFactoryRepository;
use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use ConcertoCms\CoreBundle\Util\DocumentManagerTrait;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Provider\PhpcrMenuProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateLanguageCommand extends ContainerAwareCommand
{
    private $lm;
    private $factory;
    public function __construct(LanguagesManager $lm, PageFactoryRepository $factory)
    {
        parent::__construct();
        $this->factory = $factory;
        $this->lm = $lm;
    }
    protected function configure()
    {
        $this
            ->setName("concerto:create:language")
            ->setDescription("Add a language");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
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
            ),
            $dialog->ask(
                $output,
                'Please provide a URL prefix [en]:  ',
                'en'
            )
        );
        $pagetype = $dialog->ask(
            $output,
            'Please choose a page type [simplepage]:  ',
            'simplepage'
        );

        $factory = $this->factory->getByName($pagetype);
        $page = $factory->createFromJson([]);

        $this->lm->addLocale($language, $page);
        $this->lm->flush();

        $output->writeln("Language was created successfully!");
    }
}
