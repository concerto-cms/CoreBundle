<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:41
 */
namespace ConcertoCms\CoreBundle\Navigation\Service;

class NavigationManager {
    use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm
    ) {
        $this->setDocumentManager($dm);
    }

    /**
     * @return ChildrenCollection
     */
    public function getAll()
    {
        /**
         * @var $root Route
         */
        $root = $this->dm->find(null, "/cms/routes");
        return $root->getChildren();
    }

    public function add(Locale $locale, ContentInterface $page)
    {
        $page->setSlug($locale->getPrefix());
        $page->setParent($this->dm->find(null, "/cms/pages"));
        $this->persist($page);

        $parent = $this->dm->find(null, "/cms/routes");
        $route = new LanguageRoute();
        $route->setParentDocument($this->getSplash());
        //$route->setParent($this->getSplash());
        $route->setLocale($locale);
        $route->setContent($page);
        $this->dm->persist($route);

        $event = new Event\LanguageEvent();
        $event->setLanguage($route);
        $this->dispatcher->dispatch('concerto.language.add', $event);

        $this->dm->flush();
        return $route;
    }

} 