<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 10:35
 */

namespace ConcertoCms\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use ConcertoCms\CoreBundle\Service\Content;
use ConcertoCms\CoreBundle\Service\Navigation;

class BaseController extends Controller
{
    protected function getJsonInput()
    {
        $content = $this->get("request")->getContent();
        if (empty($content)) {
            throw new BadRequestHttpException("Empty request");
        }
        $data = json_decode($content, true);
        return $data;
    }

    /**
     * @return Content
     */
    protected function getContentService()
    {
        return $this-> get("concerto_cms_core.content");
    }

    /**
     * @return Navigation
     */
    protected function getNavigationService()
    {
        return $this-> get("concerto_cms_core.navigation");
    }
}
