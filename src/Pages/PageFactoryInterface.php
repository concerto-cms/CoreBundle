<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/12/2014
 * Time: 12:27
 */

namespace ConcertoCms\CoreBundle\Pages;


use ConcertoCms\CoreBundle\Util\PublishableInterface;

interface PageFactoryInterface {
    public function createFromJson($data);
    public function updateFromJson($page, $data);
    public function getPageFQN();
}