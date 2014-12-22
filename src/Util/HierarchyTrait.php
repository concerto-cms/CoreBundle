<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 06/12/2014
 * Time: 16:21
 */
namespace ConcertoCms\CoreBundle\Util;
use JMS\Serializer\Annotation as Serializer;

trait HierarchyTrait {
    /**
     * @PHPCR\Id()
     * @Serializer\Exclude()
     */
    protected $id;

    /**
     * @PHPCR\ParentDocument()
     * @Serializer\Exclude()
     */
    protected $parent;

    /**
     * @PHPCR\NodeName()
     * @Serializer\Type("string")
     */
    protected $slug;

    /**
     * @PHPCR\Children
     * @Serializer\Exclude()
     */
    protected $children;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $parent
     * @return HierarchyTrait
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }
} 