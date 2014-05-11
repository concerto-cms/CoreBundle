<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 08:58
 */

namespace ConcertoCms\CoreBundle\Repository;


interface RepositoryInterface {
    /**
     * @param object $document
     * @param array $params
     * @return mixed
     */
    public function populate($document, $params);
    public function toJSON($document);
    public function create($params);

    public function getType();
    public function getJSView();
    public function getLabel();
}