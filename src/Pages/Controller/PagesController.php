<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 14:00
 */
namespace ConcertoCms\CoreBundle\Pages\Controller;

use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use ConcertoCms\CoreBundle\Util\HierarchyInterface;
use ConcertoCms\CoreBundle\Util\PublishableInterface;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesController
{
    use \ConcertoCms\CoreBundle\Util\JsonApiTrait;

    private $pm;

    public function __construct(PagesManager $pm)
    {
        $this->pm = $pm;
    }

    public function listAction()
    {
        $data = $this->flatten($this->pm->getSplash());
        return new JsonResponse($data);
    }

    public function getAction(Request $req, $path)
    {
        $data = $this->pm->getByUrl($path);
        if ($req->get("flatten") == "1") {
            $data = $this->flatten($data);
        }
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
        if ($object instanceof PublishableInterface) {
            $arr[] = $object;

        }
        if ($object instanceof \Doctrine\ODM\PHPCR\Document\Generic) {
            $children = $object->getChildren();
        } elseif ($object instanceof HierarchyInterface) {
            $children = $object->getChildren();
        } else {
            return $arr;
        }
        if ($children instanceof ChildrenCollection) {
            foreach ($children as $child) {
                $this->flatten($child, $arr);
            }
        }
        return $arr;
    }
}
