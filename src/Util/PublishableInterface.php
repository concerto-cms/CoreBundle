<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 06/12/2014
 * Time: 16:08
 */

namespace ConcertoCms\CoreBundle\Util;


interface PublishableInterface extends HierarchyInterface
{
    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return bool
     */
    public function isPublished();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function setSlug($slug);

    /**
     * @return array
     */
    public function getRoutes();
}
