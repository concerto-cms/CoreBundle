<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 29/05/14
 * Time: 08:29
 */
namespace ConcertoCms\CoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PagePopulateEvent extends Event
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var \ConcertoCms\CoreBundle\Document\ContentInterface
     */
    private $document;

    public function __construct(\ConcertoCms\CoreBundle\Document\ContentInterface $document, $data)
    {
        $this->setDocument($document);
        $this->setData($data);
    }
    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
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
}
