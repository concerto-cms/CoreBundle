<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:59
 */

namespace ConcertoCms\CoreBundle\Languages\Command;

use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use ConcertoCms\CoreBundle\Navigation\Model\Locale;
use ConcertoCms\CoreBundle\Document\SimplePage;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\MenuBundle\Provider\PhpcrMenuProvider;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateLanguageCommand extends ContainerAwareCommand
{
    /**
     * @var LanguagesManager
     */
    private $lm;
    public function __construct(LanguagesManager $lm)
    {
        parent::__construct();
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

        $page = new SimplePage();
        $page->setTitle("");

        $this->lm->addLocale($language, $page);
        $this->lm->flush();

        $output->writeln("Language was created successfully!");
    }
}
