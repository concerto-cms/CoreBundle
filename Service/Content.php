<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:35
 */

namespace ConcertoCms\CoreBundle\Service;


use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use ConcertoCms\CoreBundle\Document\ContentDocumentInterface;

class Content {
    const SPLASH_MODE_LANGUAGE_DETECTION = 1;
    const SPLASH_MODE_REDIRECT = 2;
    const SPLASH_MODE_PAGE = 3;

    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    private $dm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct($dm) {
        $this->dm = $dm;
    }

    public function getPage($url) {
        $route = $this->getRoute($url);
        return $route->getContent();
    }

    /**
     * @param $url string
     * @return Route
     */
    public function getRoute($url) {

    }

    public function getLanguages() {

    }

    public function addLanguage() {

    }

    public function getSplash() {

    }

    public function setSplash($mode, $argument = null) {
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


    /**
     * @param $parentUrl string
     * @param $page ContentDocumentInterface
     */
    public function createPage($parentUrl, $page) {
        $parentRoute = $this->getRoute($parentUrl);
        $parentPage = $this->dm->find(null, "/cms/pages");

        $page->setParent($parentPage);
        $this->dm->persist($page);

        $route = new Route();
        $route->setId($page->getSlug());
        $route->setName($page->getSlug());
        $route->setParent($parentRoute);
        $route->setContent($page);
        $this->dm->persist($route);
        $this->dm->flush();
    }

    public function initializeRoute() {
        // Create the root route
        $parent = $this->dm->find(null, "/cms");
        $route = new Route();
        $route->setParent($parent);
        $route->setName("routes");
        $route->setId("routes");

        $this->dm->persist($route);
        $this->dm->flush();
    }

} 