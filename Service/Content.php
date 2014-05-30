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
use ConcertoCms\CoreBundle\Event;
use ConcertoCms\CoreBundle\Extension\PageManagerContainer;
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

    private $dispatcher;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     * @param $dispatcher EventDispatcherInterface
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm,
        EventDispatcherInterface $dispatcher,
        PageManagerContainer $pmc)
    {
        $this->dm = $dm;
        $this->dispatcher = $dispatcher;
    }

    public function persist($document)
    {
        $this->dm->persist($document);
    }
    public function flush()
    {
        $this->dm->flush();
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

        $event = new Event\LanguageEvent();
        $event->setLanguage($route);
        $this->dispatcher->dispatch('concerto.language.add', $event);

        $this->dm->persist($route);
        $this->dm->flush();
    }

    public function getSplash()
    {
        return $this->getRoute("");
    }

    /**
     * @param $parentUrl string
     * @param $params array
     */
    public function createPage($parentUrl, $type, $params = array())
    {
        // Check if parentUrl is a valid route
        $parentRoute = $this->getRoute($parentUrl);
        $parentPage = $this->getPage($parentUrl);
        if (!$parentRoute) {
            throw new \InvalidArgumentException("Couldn't find route for url " . $parentUrl);
        }

        if (!$parentPage) {
            throw new \InvalidArgumentException("Couldn't find parent page with url " . $parentUrl);
        }

        // Create a new Page using the pagemanager events
        $createEvent = new Event\PageCreateEvent($type);
        $this->dispatcher->dispatch(PageManagerContainer::CREATE_EVENT, $createEvent);


        $page = $createEvent->getDocument();
        if ($page == null) {
            throw new \UnexpectedValueException("Document was not created after dispatching event " . PageManagerContainer::CREATE_EVENT);
        }

        $page->setParent($parentPage);

        // If there are params, perform populate as well
        if (count($params)) {
            $this->populate($page, $params);
        }

        $this->persist($page);
        // Create a route for the new page
        $route = new Route();
        $route->setName($page->getSlug());
        $route->setDefault("_locale", $parentRoute->getDefault("_locale"));
        $route->setParentDocument($parentRoute);
        $route->setContent($page);
        $this->dm->persist($route);
        return $route;
    }

    public function populate($page, $params)
    {
        $event = new Event\PagePopulateEvent($page, $params);
        $this->dispatcher->dispatch(PageManagerContainer::POPULATE_EVENT, $event);
    }


    public function initializeRoute()
    {
        // Create the root route
        $parent = $this->dm->find(null, "/cms");
        $route = new SplashRoute();
        $route->setParentDocument($parent);
        $route->setName("routes");
        //$route->setId("routes");

        $this->dm->persist($route);
        $this->dm->flush();
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
