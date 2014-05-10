<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:42
 */

namespace ConcertoCms\CoreBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Page implements ContentInterface
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
     * @PHPCR\String(nullable=true)
     */
    protected $title;

    /**
     * @PHPCR\String(nullable=true)
     */
    protected $description;

    /**
     * @PHPCR\String(nullable=true)
     */
    protected $content;

    /**
     * @PHPCR\Children
     */
    protected $children;

    /**
     * @PHPCR\Referrers(
     *     referringDocument="Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route",
     *     referencedBy="content"
     * )
     */
    protected $routes;


    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function showChildrenInList()
    {
        return true;
    }
    public function showInList()
    {
        return true;
    }


    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $parent
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

    /**
     * @return mixed
     */
    public function getRoutes()
    {
        return $this->routes;
    }

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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getClassname()
    {
        return "ConcertoCMFCoreBundle:Page";
    }

    public function set($params)
    {
        if (isset($params["description"])) {
            $this->setDescription($params["description"]);
        }
        if (isset($params["content"])) {
            $this->setContent($params["content"]);
        }
        if (isset($params["title"])) {
            $this->setTitle($params["title"]);
        }
        return $this;
    }

    public function getRoute()
    {
        $routes = $this->getRoutes();
        return $routes[0];
    }

    public function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "slug" => $this->getSlug(),
            "description" => $this->getDescription(),
            "content" => $this->getContent(),
            "type" => $this->getClassname()
        );
    }
}
