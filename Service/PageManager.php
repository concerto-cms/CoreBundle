<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 08:58
 */
namespace ConcertoCms\CoreBundle\Service;

use ConcertoCms\CoreBundle\Document\ContentInterface;
use ConcertoCms\CoreBundle\Document\Page;
use ConcertoCms\CoreBundle\Event\PageCreateEvent;
use ConcertoCms\CoreBundle\Event\PagePopulateEvent;
use ConcertoCms\CoreBundle\Extension\PageManagerInterface;
use ConcertoCms\CoreBundle\Extension\PageType;

class PageManager implements PageManagerInterface
{
    /**
     * @return \ConcertoCms\CoreBundle\Extension\PageType[]
     */
    public function getPageTypes()
    {
        $page = new PageType(
            "ConcertoCmsCoreBundle:Page",
            "Basic page",
            "View.PageContent_Page"
        );
        return array($page);
    }

    /**
     * @param PagePopulateEvent $event
     * @return void
     */
    public function onPopulate(PagePopulateEvent $event)
    {
        if ($event->getDocument() instanceof ContentInterface) {
            $this->populate($event->getDocument(), $event->getData());
        }
    }

    /**
     * @param PagePopulateEvent $event
     * @return void
     */
    public function onCreate(PageCreateEvent $event)
    {
        if ($event->getType()->getName() == "ConcertoCmsCoreBundle:Page") {
            $event->setDocument(new Page());
        }
    }

    /**
     * @param ContentInterface $document
     * @param array $params
     * @return mixed
     */
    private function populate($document, $params)
    {
        if (isset($params["description"])) {
            $document->setDescription($params["description"]);
        }
        if (isset($params["content"])) {
            $document->setContent($params["content"]);
        }
        if (isset($params["title"])) {
            $document->setTitle($params["title"]);
        }
        return $this;
    }
}
