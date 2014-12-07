<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 13:58
 */

namespace ConcertoCms\CoreBundle\Util;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait JsonApiTrait {

    protected function getJsonInput(Request $req) {
        $content = $req->getContent();
        if (empty($content)) {
            throw new BadRequestHttpException("Empty request");
        }
        $data = json_decode($content, true);
        return $data;
    }
} 