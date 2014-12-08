<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 20:57
 */

namespace ConcertoCms\CoreBundle\Util;


interface HierarchyInterface {
    public function getId();
    public function setParent($parent);
    public function getParent();
    public function setSlug($slug);
    public function getSlug();
    public function getChildren();

} 