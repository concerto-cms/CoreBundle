<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:42
 */

namespace ConcertoCms\CoreBundle\Util;

use ConcertoCms\CoreBundle\Util\HierarchyTrait;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
abstract class AbstractPage implements PublishableInterface
{
    use HierarchyTrait;

    /**
     * @PHPCR\String(nullable=true)
     */
    protected $title;

    /**
     * @PHPCR\String(nullable=true)
     */
    protected $metaDescription;

    /**
     * @PHPCR\Referrers(
     *     referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *     referencedBy="content"
     * )
     */
    protected $routes;

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $description
     */
    public function setMetaDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
