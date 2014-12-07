<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:32
 */

class RoutesManager {
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
     * @param $url string
     * @return Route
     */
    public function getByUrl($url)
    {
        $url = ltrim($url, "/");
        if (!empty($url)) {
            $url = "/" . $url;
        }
        return $this->getDocumentManager()->find(null, "/cms/routes" . $url);
    }

    public function createRoute($parentUrl, ContentInterface $page)
    {
        // Check if parentUrl is a valid route
        $parentRoute = $this->getRoute($parentUrl);
        if (!$parentRoute) {
            throw new \InvalidArgumentException("Couldn't find route for url " . $parentUrl);
        }
        // Create a route for the new page
        $route = new Route();
        $route->setName($page->getSlug());
        $route->setDefault("_locale", $parentRoute->getDefault("_locale"));
        $route->setParentDocument($parentRoute);
        $route->setContent($page);
        $this->getDocumentManager()->persist($route);
        return $route;

    }

    public function initialize()
    {
        // Create the root route
        $parent = $this->getDocumentManager()->find(null, "/cms");
        $route = new SplashRoute();
        $route->setParentDocument($parent);
        $route->setName("routes");
        //$route->setId("routes");

        
        $this->getDocumentManager()->persist($route);
        $this->getDocumentManager()->flush();
        return $route;
    }
} 