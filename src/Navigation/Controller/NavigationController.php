<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 14:00
 */
namespace ConcertoCms\CoreBundle\Navigation\Controller;

use ConcertoCms\CoreBundle\Navigation\Service\NavigationManager;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use ConcertoCms\CoreBundle\Util\PublishableInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\HierarchyInterface;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NavigationController
{
    use \ConcertoCms\CoreBundle\Util\JsonApiTrait;

    private $nm;

    public function __construct(NavigationManager $nm)
    {
        $this->nm = $nm;
    }

    public function listAction($path = null)
    {
        $data = $this->flatten($this->nm->getAll());
        return new JsonResponse($data);
    }

    public function postAction(Request $req, $path)
    {
        $post = $this->getJsonInput($req);
        $page = $this->pm->createPage($path, $post["type"], $post["page"]);
        $this->pm->flush();
        return new JsonResponse($page);

    }

    public function putAction(Request $req, $path)
    {
        $page = $this->pm->getByUrl($path);
        $this->pm->update($page, $this->getJsonInput($req));
        $this->pm->flush();
        return new JsonResponse($page);
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
