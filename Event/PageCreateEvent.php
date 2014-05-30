<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 29/05/14
 * Time: 08:29
 */

namespace ConcertoCms\CoreBundle\Event;


use ConcertoCms\CoreBundle\Extension\PageType;
use Symfony\Component\EventDispatcher\Event;

class PageCreateEvent extends Event
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var \ConcertoCms\CoreBundle\Document\ContentInterface
     */
    private $document;

    public function __construct($type)
    {
        $this->setType($type);
    }

    /**
     * @param \ConcertoCms\CoreBundle\Document\ContentInterface $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return \ConcertoCms\CoreBundle\Document\ContentInterface
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return PageType
     */
    public function getType()
    {
        return $this->type;
    }
}
