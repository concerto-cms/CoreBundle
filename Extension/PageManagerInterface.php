<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 08:58
 */

namespace ConcertoCms\CoreBundle\Extension;

use ConcertoCms\CoreBundle\Document\ContentInterface;
use ConcertoCms\CoreBundle\Event\PageCreateEvent;
use ConcertoCms\CoreBundle\Event\PagePopulateEvent;

interface PageManagerInterface
{
    /**
     * @return \ConcertoCms\CoreBundle\Extension\PageType[]
     */
    public function getPageTypes();

    /**
     * @param PagePopulateEvent $event
     * @return void
     */
    public function onPopulate(PagePopulateEvent $event);

    /**
     * @param PagePopulateEvent $event
     * @return void
     */
    public function onCreate(PageCreateEvent $event);
}
