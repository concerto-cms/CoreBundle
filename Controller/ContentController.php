<?php
namespace ConcertoCms\CoreBundle\Controller;

use ConcertoCms\CoreBundle\Document\ContentInterface;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Document\RouteInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class ContentController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $pagemanager = $this->container->get('concerto_cms_core.pagemanager_container');
        $pageTypes = $pagemanager->getPageTypes();

        $data = array();
        $this->populatePageData($data, $this->getContentService()->getSplash());
        return $this->render('ConcertoCmsCoreBundle:Content:index.html.twig', array(
                "pages" => $data,
                "pagetypes" => $pageTypes
        ));
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

        $this->getContentService()->populate($page, $data);
        $this->getContentService()->flush();
        return new JsonResponse($page);
    }

    public function postAction($path)
    {
        $data = $this->getJsonInput();
        if (!isset($data["type"])) {
            throw new BadRequestHttpException("No type given");
        }
        $type = $data["type"];
        unset($data["type"]);

        $page = $this->getContentService()->createPage($path, $type, $data);

        $this->getContentService()->flush();
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
         * @var $child RouteInterface
         */
        foreach ($children as $child) {
            /**
             * @var $content ContentInterface
             */
            $content = $child->getContent();
            $className = $content->getClassName();
            $pageType = $this->container->get("concerto_cms_core.pagemanager_container")->getPageType($className);
            if ($pageType && $pageType->getShowInList()) {
                $pageData[] = $child;
                $this->populatePageData($pageData, $child);
            }
        }
    }
}
