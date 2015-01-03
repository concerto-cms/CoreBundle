<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 06/12/2014
 * Time: 16:21
 */
namespace ConcertoCms\CoreBundle\Util;

trait HierarchyTrait
{
    /**
     * @PHPCR\Id()
     */
    protected $id;

    /**
     * @PHPCR\ParentDocument()
     */
    protected $parent;

    /**
     * @PHPCR\NodeName()
     */
    protected $slug;

    /**
     * @PHPCR\Children
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
