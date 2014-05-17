<?php
namespace ConcertoCms\CoreBundle\Controller;

use ConcertoCms\CoreBundle\Document\ContentInterface;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Document\RouteInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class ContentController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $data = array();
        $this->populatePageData($data, $this->getContentService()->getSplash());
        return $this->render('ConcertoCmsCoreBundle:Content:index.html.twig', array("pages" => $data));
    }

    public function getAction($path)
    {
        $page = $path ? $this->getContentService()->getRoute($path) : $this->getContentService()->getSplash();
        $data = array();
        $this->populatePageData($data, $page);
        return new JsonResponse($data);
    }

    public function putAction($path)
    {
        $data = $this->getJsonInput();
        $page = $this->getContentService()->getPage($path);
        if (!$page) {
            throw $this->createNotFoundException("Page with id '/cms/pages/" . $path . "' not found");
        }
        $repository = $this->getContentService()->getRepository($page->getClassname());
        $repository->populate($page, $data);
        $this->getContentService()->save($page);
        return new JsonResponse($page);
    }

    public function postAction($path)
    {
        $data = $this->getJsonInput();
        $repository = $this->getContentService()->getRepository($data["type"]);
        $page = $repository->create($data);
        $this->getContentService()->save($page);
        return new JsonResponse($page);
    }

    public function deleteAction($path)
    {
        return new ServiceUnavailableHttpException("Deleting is not implemented yet");
    }

    /**
     * @param array $pageData
     * @param RouteInterface $route
     */
    protected function populatePageData(&$pageData, $route)
    {
        $children = $route->getChildren();
        /**
         * @var $route RouteInterface
         */
        foreach ($children as $child) {
            $pageData[] = $child;
            $this->populatePageData($pageData, $child);
        }
    }
}
