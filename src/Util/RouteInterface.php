<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 15/03/14
 * Time: 16:15
 */

namespace ConcertoCms\CoreBundle\Util;


interface RouteInterface extends \JsonSerializable
{
    public function getId();
    public function getName();
    public function getContent();
    public function getParent();
    public function getChildren();
}
