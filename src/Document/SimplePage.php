<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 15:43
 */
namespace ConcertoCms\CoreBundle\Document;

use ConcertoCms\CoreBundle\Util\AbstractPage;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class SimplePage extends AbstractPage {
    /**
     * @PHPCR\String(nullable=true)
     */
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