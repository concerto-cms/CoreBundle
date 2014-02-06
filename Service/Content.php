<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:35
 */

namespace ConcertoCms\CoreBundle\Service;


use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Orm\Route;

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

    public function createPage($parentUrl, $page) {

    }

} 