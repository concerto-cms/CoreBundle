<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 08:58
 */

namespace ConcertoCms\CoreBundle\Extension;

use ConcertoCms\CoreBundle\Document\ContentInterface;

interface PageManagerInterface
{
    /**
     * @param object $document
     * @param array $params
     * @return mixed
     */
    public function populate($document, $params);
    public function toJSON($document);

    /**
     * @param $params
     * @return ContentInterface
     */
    public function create($params);

    public function getType();
    public function getJSView();
    public function getLabel();
    public function getAllowedChildPageTypes();
}
