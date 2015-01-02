<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 14:00
 */
namespace ConcertoCms\CoreBundle\Navigation\Controller;

use ConcertoCms\CoreBundle\Navigation\Service\NavigationManager;
use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use ConcertoCms\CoreBundle\Util\PublishableInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\HierarchyInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NavigationController
{
    use \ConcertoCms\CoreBundle\Util\JsonApiTrait;

    private $nm;
    private $rm;

    public function __construct(NavigationManager $nm, RoutesManager $rm)
    {
        $this->nm = $nm;
        $this->rm = $rm;
    }

    public function listAction($path = null)
    {
        $data = $this->flatten($this->nm->getAll());
        return new JsonResponse($data);
    }

    public function putAction(Request $req, $path)
    {
        $params = $this->getJsonInput($req);

        $menu = $this->nm->getByUrl($path);
        if (!$menu) {
            throw new NotFoundHttpException("Menu with id '/cms/menu/" . $path . "' not found");
        }

        if (isset($params["label"])) {
            $menu->setLabel($params["label"]);
        }

        if (isset($params["uri"])) {
            $page = $this->rm->getByUrl($params["uri"]);
            if ($page) {
                $menu->setContent($page);
                $menu->setUri(null);
            } else {
                $menu->setUri($params["uri"]);
                $menu->setContent(null);
            }
        }
        /*
        if (isset($params["orderBefore"])) {
            $this->getNavigationService()->reorder($menu, $params["orderBefore"]);
        }
        */

        $this->nm->flush();
        return new JsonResponse($this->getMenuJSON($menu));
    }

    public function postAction(Request $req, $path)
    {
        $params = $this->getJsonInput($req);
        $parent = $this->nm->getByUrl($path);
        if (!$parent) {
            throw new NotFoundHttpException("Menu with id '/cms/menu/" . $path . "' not found");
        }

        $menu = new MenuNode();
        $menu->setParentDocument($parent);
        $menu->setName(\Ferrandini\Urlizer::urlize($params["label"]));
        $menu->setLabel($params["label"]);

        if (isset($params["uri"])) {
            $page = $this->rm->getByUrl($params["uri"]);
            if ($page) {
                $menu->setContent($page);
                $menu->setUri(null);
            } else {
                $menu->setUri($params["uri"]);
                $menu->setContent(null);
            }
        }
        $this->nm->persist($menu);

        $this->nm->flush();
        return new JsonResponse($this->getMenuJSON($menu));
    }

    public function deleteAction($path)
    {
        $page = $this->pm->getByUrl($path);
        $this->pm->delete($page);
        return new JsonResponse(["success"=> true]);
    }

    private function flatten($object, &$arr = [])
    {
        if (is_array($object)) {
            foreach ($object as $item) {
                $this->flatten($item, $arr);
            }
            return $arr;
        }
        $arr[] = $this->getMenuJSON($object);
        $children = $object->getChildren();
        foreach ($children as $child) {
            $this->flatten($child, $arr);
        }
        return $arr;
    }

    /**
     * @param MenuNode $node
     * @return array
     */
    private function getMenuJSON($node)
    {
        $item = array(
            "id" => $node->getId(),
            "name" => $node->getName(),
            "label" => $node->getLabel(),
            "parent" => $node->getParent()->getId()
        );
        $item["parent"] = ltrim(str_replace("/cms/menu", "", $item["parent"]), "/");
        if ($node->getContent()) {
            $item["uri"] = str_replace("/cms/routes/", "", $node->getContent()->getId());
        } else {
            $item["uri"] = $node->getUri();
        }
        return $item;
    }
}
