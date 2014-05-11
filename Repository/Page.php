<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 08:58
 */

namespace ConcertoCms\CoreBundle\Repository;


class Page implements RepositoryInterface {
    /**
     * @param object $document
     * @param array $params
     * @return mixed
     */
    public function populate($document, $params)
    {
        if (isset($params["description"])) {
            $document->setDescription($params["description"]);
        }
        if (isset($params["content"])) {
            $document->setContent($params["content"]);
        }
        if (isset($params["title"])) {
            $document->setTitle($params["title"]);
        }
        return $this;
    }
    public function create($params) {
        $page = new Page();
        $this->populate($page, $params);
        return $page;
    }

    public function toJSON($document)
    {
        // TODO: Implement toJSON() method.
    }

    public function getType()
    {
        // TODO: Implement getType() method.
    }

    public function getJSView()
    {
        // TODO: Implement getJSView() method.
    }

    public function getLabel()
    {
        // TODO: Implement getLabel() method.
    }

} 