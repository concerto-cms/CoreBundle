<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 29/05/14
 * Time: 08:17
 */

namespace ConcertoCms\CoreBundle\Extension;


use ConcertoCms\CoreBundle\Document\ContentInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PageManagerContainer
{
    const CREATE_EVENT = "concerto.content.create";
    const POPULATE_EVENT = "concerto.content.populate";

    /**
     * @var PageType[]
     */
    private $pageTypes = array();
    private $dispatcher;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    public function addManager(PageManagerInterface $service)
    {
        foreach ($service->getPageTypes() as $pt) {
            $this->pageTypes[] = $pt;
        }
        $this->dispatcher->addListener(self::CREATE_EVENT, array($service, "onCreate"));
        $this->dispatcher->addListener(self::POPULATE_EVENT, array($service, "onPopulate"));
    }
    public function getPageTypes()
    {
        return $this->pageTypes;
    }
    public function getPageType($type)
    {
        if ($type instanceof ContentInterface) {
            $type = $type->getClassname();
        }
        foreach ($this->pageTypes as $pagetype) {
            if ($pagetype->getName() == $type) {
                return $pagetype;
            }
        }
        return null;
    }
}
