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
use ConcertoCms\CoreBundle\Model\Locale;
use ConcertoCms\CoreBundle\Document\Route;
use ConcertoCms\CoreBundle\Document\ContentInterface;

class Content
{
    const SPLASH_MODE_LANGUAGE_DETECTION = 1;
    const SPLASH_MODE_REDIRECT = 2;
    const SPLASH_MODE_PAGE = 3;

    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    private $dm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     * @param $dispatcher EventDispatcher
     */
    public function __construct(\Doctrine\ODM\PHPCR\DocumentManager $dm, \Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher $dispatcher)
    {
        $this->dm = $dm;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $url string
     * @return null|ContentInterface
     */
    public function getPage($url)
    {
        return $this->dm->find(null, "/cms/pages/" . $url);
    }

    /**
     * @param $url string
     * @return Route
     */
    public function getRoute($url)
    {
        if (!empty($url) && substr($url, 0,1) !== "/") {
            $url = "/" . $url;
        }
        return $this->dm->find(null, "/cms/routes" . $url);
    }


    /**
     * @return LanguageRoute
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

    public function setSplash($mode, $argument = null)
    {
        switch ($mode) {
            case self::SPLASH_MODE_LANGUAGE_DETECTION:
                break;
            case self::SPLASH_MODE_PAGE:
                break;
            case self::SPLASH_MODE_REDIRECT:
                break;
            default:
                throw new \InvalidArgumentException("Illegal mode given");
                break;
        }
    }

    private function storePage($parentUrl, ContentInterface $page)
    {
        $parentPage = $this->dm->find(null, "/cms/pages" . $parentUrl);
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
        $page = $this->storePage($parentUrl, $page);

        $route = new Route();
        $route->setName($page->getSlug());
        $route->setDefault("_locale", $parentRoute->getDefault("_locale"));

        $route->setParent($parentRoute);
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

    public function save($object)
    {
        $this->dm->persist($object);
        $this->dm->flush();
    }
}
