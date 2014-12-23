<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 14:00
 */
namespace ConcertoCms\CoreBundle\Languages\Controller;

use ConcertoCms\CoreBundle\Document\SimplePage;
use ConcertoCms\CoreBundle\Languages\Model\Locale;
use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use ConcertoCms\CoreBundle\Pages\Service\PagesManager;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use ConcertoCms\CoreBundle\Util\HierarchyInterface;
use ConcertoCms\CoreBundle\Util\PublishableInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguagesController {
    use \ConcertoCms\CoreBundle\Util\JsonApiTrait;

    private $lm;

    public function __construct(LanguagesManager $lm) {
        $this->lm = $lm;
    }

    public function listAction() {
        $data = $this->lm->getAll()->toArray();
        return new JsonResponse($data);
    }

    public function getAction($path) {
        $language = $this->lm->getBySlug($path);
        return new JsonResponse($language);
    }

    public function postAction(Request $req) {
        $post = $this->getJsonInput($req);
        $locale = new Locale($post["isoCode"], $post["description"], $post["name"]);
        $route = $this->lm->addLocale($locale, new SimplePage());
        $this->lm->flush();
        return new JsonResponse($route);

    }

    public function putAction(Request $req, $path) {
        $language = $this->lm->getBySlug($path);
        $post = $this->getJsonInput($req);
        $locale = new Locale($post["isoCode"], $post["description"], $post["name"]);
        $language->setLocale($locale);
        $this->lm->flush();
        return new JsonResponse($language);
    }

    public function deleteAction($path) {
        $language = $this->lm->getBySlug($path);
        $this->lm->delete($language);
        return new JsonResponse(["success"=> true]);
    }
}