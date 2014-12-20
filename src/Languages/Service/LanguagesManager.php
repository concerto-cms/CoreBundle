<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 15:38
 */

namespace ConcertoCms\CoreBundle\Languages\Service;
use ConcertoCms\CoreBundle\Languages\Model\Locale;
use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;
use ConcertoCms\CoreBundle\Util\PublishableInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\DocumentManager;


class LanguagesManager {
    use DocumentManagerTrait;

    /**
     * @var RoutesManager
     */
    private $rm;

    private $pm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(
        DocumentManager $dm,
        RoutesManager $rm,
        PagesManager $pm
    ) {
        $this->setDocumentManager($dm);
        $this->rm = $rm;
        $this->pm = $pm;
    }

    /**
     * @param Locale $locale
     * @param PublishableInterface $page
     * @return LanguageRoute
     */
    public function addLocale(Locale $locale, PublishableInterface $page) {
        $routeParent = $this->rm->getRoot();
        $pageParent = $this->pm->getSplash();

        $page->setSlug($locale->getPrefix());
        $page->setParent($pageParent);
        $this->persist($page);

        $route = new LanguageRoute();
        $route->setParentDocument($routeParent);
        $route->setLocale($locale);
        $route->setContent($page);
        $this->persist($route);
        return $route;
    }


    /**
     * @return ChildrenCollection
     */
    public function getAll() {
        $root = $this->rm->getRoot();
        return $root->getChildren();
    }
}