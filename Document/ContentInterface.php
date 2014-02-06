<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:43
 */

namespace ConcertoCms\CoreBundle\Document;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

interface ContentDocumentInterface extends RouteReferrersReadInterface {
    public function getId();
    public function getClassname();
    public function toJson();
    public function getSlug();
    public function setSlug($slug);
    public function getParent();
    public function setParent($parent);
    public function getTitle();
    public function setTitle($title);
    public function set($params);
    public function getRoute();
} 