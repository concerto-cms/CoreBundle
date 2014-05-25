<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:35
 */

namespace ConcertoCms\CoreBundle\Service;

use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Document\SplashRoute;
use ConcertoCms\CoreBundle\Event\LanguageEvent;
use ConcertoCms\CoreBundle\Extension\PageManagerInterface;
use ConcertoCms\CoreBundle\Model\Locale;
use ConcertoCms\CoreBundle\Document\Route;
use ConcertoCms\CoreBundle\Document\ContentInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Content
{
    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    private $dm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     * @param $dispatcher EventDispatcherInterface
     */
    public function __construct(\Doctrine\ODM\PHPCR\DocumentManager $dm, EventDispatcherInterface $dispatcher)
    {
        $this->dm = $dm;
        $this->dispatcher = $dispatcher;
    }

    private $pageManagers = array();

    public function addManager(PageManagerInterface $pagemanager)
    {
        $type = $pagemanager->getType();
        $this->pageManagers[$type] = $pagemanager;
    }

    /**
     * @param $url string
     * @return null|ContentInterface
     */
    public function getPage($url)
    {
        $url = ltrim($url, "/");
        return $this->dm->find(null, "/cms/pages/" . $url);
    }

    /**
     * @param $url string
     * @return Route
     */
    public function getRoute($url)
    {
        $url = ltrim($url, "/");
        if (!empty($url)) {
            $url = "/" . $url;
        }
        return $this->dm->find(null, "/cms/routes" . $url);
    }


    /**
     * @return ChildrenCollection
     */
    public function getLanguages()
    {
        /**
         * @var $root Route
         */
        $root = $this->dm->find(null, "/cms/routes");
        return $root->getChildren();
    }

    public function addLanguage(Locale $locale, ContentInterface $page)
    {
        $page->setSlug($locale->getPrefix());
        $page = $this->storePage("", $page);

        $parent = $this->dm->find(null, "/cms/routes");
        $route = new LanguageRoute();
        $route->setParent($parent);
        $route->setLocale($locale);
        $route->setContent($page);

        $event = new LanguageEvent();
        $event->setLanguage($route);
        $this->dispatcher->dispatch('concerto.language.add', $event);

        $this->dm->persist($route);
        $this->dm->flush();

    }

    public function getSplash()
    {
        return $this->getRoute("");
    }

    private function storePage($parentUrl, ContentInterface $page)
    {
        $parentUrl = "/" . ltrim($parentUrl, "/");
        $parentPage = $this->dm->find(null, "/cms/pages" . $parentUrl);
        if (!$parentPage) {
            throw new \InvalidArgumentException("Couldn't find route for url " . $parentUrl);
        }
        $page->setParent($parentPage);
        $this->dm->persist($page);
        $this->dm->flush();
        return $page;
    }
    /**
     * @param $parentUrl string
     * @param $page ContentInterface
     */
    public function createPage($parentUrl, $page)
    {
        $parentRoute = $this->getRoute($parentUrl);
        if (!$parentRoute) {
            throw new \InvalidArgumentException("Couldn't find route for url " . $parentUrl);
        }
        $page = $this->storePage($parentUrl, $page);

        $route = new Route();
        $route->setName($page->getSlug());
        $route->setDefault("_locale", $parentRoute->getDefault("_locale"));

        $route->setParentDocument($parentRoute);
//        $route->setParent($parentRoute);
        $route->setContent($page);
        $this->dm->persist($route);
        $this->dm->flush();
        return $route;
    }

    public function initializeRoute()
    {
        // Create the root route
        $parent = $this->dm->find(null, "/cms");
        $route = new SplashRoute();
        $route->setParent($parent);
        $route->setName("routes");
        //$route->setId("routes");

        $this->dm->persist($route);
        $this->dm->flush();
    }

    /**
     * @param $type
     * @return PageManagerInterface
     */
    public function getManager($type)
    {
        return $this->pageManagers[$type];
    }

    public function save($object)
    {
        $this->dm->persist($object);
        $this->dm->flush();
    }

    public function getPagetypes()
    {
        $types = array();
        /**
         * @var $repo PageManagerInterface
         */
        foreach ($this->pageManagers as $id => $repo) {
            $type = array(
                "id" => $id,
                "label" => $repo->getLabel(),
                "view" => $repo->getJSView(),
                "allowChildPageTypes" => $repo->getAllowedChildPageTypes()
            );
            $types[] = $type;
        }
        return $types;
    }
}
