<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 15:43
 */

class SimplePage extends \ConcertoCms\CoreBundle\Util\AbstractPage {

    protected $content;

    public function isPublished() {
        return true;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


} 