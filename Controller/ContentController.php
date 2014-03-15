<?php
namespace ConcertoCms\CoreBundle\Controller;

use ConcertoCms\CoreBundle\Document\ContentInterface;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Service\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ConcertoCms\CoreBundle\Document\RouteInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContentController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConcertoCmsCoreBundle:Content:index.html.twig', array("pages" => $this->getPages()));
    }

    public function getPagesAction()
    {
        return new JsonResponse($this->getPages());
    }

    private function getPages()
    {
        $data = array();
        $splash = $this->getDocumentManager()->getSplash();
        $this->populatePageData($data, $splash);
        return $data;
    }

    /**
     * @param array $pageData
     * @param RouteInterface $route
     */
    private function populatePageData(&$pageData, $route)
    {
        $pageData[] = $route;
        $children = $route->getChildren();
        /**
         * @var $route RouteInterface
         */
        foreach ($children as $route) {
            $this->populatePageData($pageData, $route);
        }
    }

    /**
     * @return Content
     */
    private function getDocumentManager()
    {
        return $this-> get("concerto_cms_core.contentmanager");
    }
}
