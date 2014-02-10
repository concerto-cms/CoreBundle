<?php
namespace ConcertoCms\CoreBundle\Controller;

use ConcertoCms\CoreBundle\Document\ContentDocumentInterface;
use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Service\Content;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class ContentController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConcertoCmsCoreBundle:Content:index.html.twig');


    }

    public function getPagesAction()
    {

        var_dump($this->getPages());
        die();
    }

    private function getPages()
    {
        $data = array();
        $data["splash"] = null;
        $splash = $this->getDocumentManager()->getRoute("");

        $languages = $this->getDocumentManager()->getLanguages();
        /**
         * @var $lang LanguageRoute
         * @var $page ContentDocumentInterface
         */
        foreach ($languages as $lang) {
            $locale = $lang->getLocale();
            $page = $lang->getContent();

            $data[$locale->getPrefix()] = array(
                "iso" => $locale->getIsoCode(),
                "description" => $locale->getName(),
                "prefix" => $lang->getName()
            );

            $pageData = array($page->toJson());

            $this->populatePageData($pageData, $lang->getChildren());
            $data[$locale->getPrefix()]["pages"] = $pageData;

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
