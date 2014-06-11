<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 25/05/14
 * Time: 16:15
 */

namespace ConcertoCms\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;

class NavigationController extends BaseController
{
    public function indexAction()
    {

        $languages = array_values($this->getContentService()->getLanguages()->toArray());

        return $this->render('ConcertoCmsCoreBundle:Navigation:index.html.twig', array(
                "menus" => $this->getMenus(),
                "languages" => $languages
            ));
    }

    public function getAction()
    {
        return new JsonResponse($this->getMenus());
    }

    public function putAction($path)
    {
        $content = $this->getJsonInput();

        $menu = $this->getNavigationService()->getMenu($path);
        if (!$menu) {
            throw $this->createNotFoundException("Menu with id '/cms/menu/" . $path . "' not found");
        }
        $params = json_decode($content, true); // 2nd param to get as array

        if (isset($params["label"])) {
            $menu->setLabel($params["label"]);
        }

        if (isset($params["uri"])) {
            $page = $this->getContentService()->getRoute($params["uri"]);
            if ($page) {
                $menu->setContent($page);
                $menu->setUri(null);
            } else {
                $menu->setUri($params["uri"]);
                $menu->setContent(null);
            }
        }
        if (isset($params["orderBefore"])) {
            $this->getNavigationService()->reorder($menu, $params["orderBefore"]);
        }

        $this->getNavigationService()->save($menu);
        return new JsonResponse($this->getMenuJSON($menu));
    }

    public function postAction($path)
    {
        $parent = $this->getNavigationService()->getMenu($path);
        if (!$parent) {
            throw $this->createNotFoundException("Menu with id '/cms/menu/" . $path . "' not found");
        }

        $content = $this->get("request")->getContent();
        if (empty($content)) {
            throw $this->createNotFoundException("Empty request");
        }
        $params = json_decode($content, true); // 2nd param to get as array

        $menu = new MenuNode();
        $menu->setParent($parent);
        $menu->setName(\Ferrandini\Urlizer::urlize($params["label"]));
        $menu->setLabel($params["label"]);

        $page = $this->getContentService()->getRoute($params["uri"]);
        if ($page) {
            $menu->setContent($page);
            $menu->setUri(null);
        } else {
            $menu->setUri($params["uri"]);
            $menu->setContent(null);
        }

        $this->getNavigationService()->save($menu);
        return new JsonResponse($this->getMenuJSON($menu));
    }

    private function getMenus()
    {
        $data = array();
        $menus = $this->getNavigationService()->getMenus();
        $this->populateMenuData($data, $menus);
        return $data;
    }

    /**
     * @param array $pageData
     * @param MenuNode $menu
     */
    private function populateMenuData(&$menuData, $menu)
    {
        /**
         * @var $node MenuNode
         */
        foreach ($menu as $node) {
            $menuData[] = $this->getMenuJSON($node);
            $this->populateMenuData($menuData, $node->getChildren());
        }
    }

    private function getMenuJSON($node)
    {
        $item = array(
            "id" => $node->getId(),
            "name" => $node->getName(),
            "label" => $node->getLabel(),
            "parent" => $node->getParent()->getId()
        );
        $item["id"] = ltrim(str_replace("/cms/menu", "", $item["id"]), "/");
        $item["parent"] = ltrim(str_replace("/cms/menu", "", $item["parent"]), "/");
        if ($node->getContent()) {
            $item["uri"] = str_replace("/cms/routes/", "", $node->getContent()->getId());
        } else {
            $item["uri"] = $node->getUri();
        }
        return $item;
    }
}
