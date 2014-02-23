<?php
namespace ConcertoCms\CoreBundle\Controller;

use ConcertoCms\CoreBundle\Document\ContentDocumentInterface;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Service\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        $languages = $this->getDocumentManager()->getLanguages();
        /**
         * @var $lang LanguageRoute
         * @var $page ContentDocumentInterface
         */
        foreach ($languages as $lang) {
            $locale = $lang->getLocale();
            $page = $lang->getContent()->toJson();

            $page["iso"] = $locale->getIsoCode();
            $page["description"] = $locale->getName();
            $page["prefix"] = $locale->getPrefix();

            $data[] = $page;
            $this->populatePageData($data, $lang->getChildren());
        }
        return $data;
    }

    private function populatePageData(&$pageData, $children)
    {
        /**
         * @var $route Route
         */
        foreach ($children as $route) {
            $pageData[] = $route->getContent()->toJson();
            $this->populatePageData($pageData, $route->getChildren());
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
