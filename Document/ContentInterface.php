<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 19:43
 */

namespace ConcertoCms\CoreBundle\Document;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;

/**
 * Interface ContentDocumentInterface
 * @package ConcertoCms\CoreBundle\Document
 */
interface ContentInterface extends RouteReferrersReadInterface, \JsonSerializable
{
    public function getId();
    public function getClassname();
    public function getSlug();
    public function setSlug($slug);
    public function getParent();
    public function setParent($parent);
    public function getTitle();
    public function setTitle($title);
    public function showInList();
    public function showChildrenInList();
    public function getChildren();

    /**
     * @return RouteInterface
     */
    public function getRoute();
}
