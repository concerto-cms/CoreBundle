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
     *     referringDocument="Route",
     *     referencedBy="content"
     * )
     * @var \Doctrine\ODM\PHPCR\ReferrersCollection
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
     * @param string $description
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
        return $this->metaDescription;
    }

    /**
     * @return \Doctrine\ODM\PHPCR\ReferrersCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }
}
