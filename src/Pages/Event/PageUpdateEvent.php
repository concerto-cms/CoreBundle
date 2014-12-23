<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/12/2014
 * Time: 20:46
 */
namespace ConcertoCms\CoreBundle\Pages\Event;

use ConcertoCms\CoreBundle\Util\PublishableInterface;

class PageUpdateEvent extends \Symfony\Component\EventDispatcher\Event
{
    private $page;
    private $params;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }


    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}
