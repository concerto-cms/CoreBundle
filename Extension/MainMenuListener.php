<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 25/05/14
 * Time: 22:57
 */

namespace ConcertoCms\CoreBundle\Extension;

use ConcertoCms\CoreBundle\Event\MenuEvent;

class MainMenuListener
{
    public function onBuild(MenuEvent $event)
    {
        $content = $event->addChild(
            "Content",
            array(
                'route' => 'concerto_cms_core_content'
            )
        );
        $navigation = $event->addChild(
            "Navigation",
            array(
                "route" => "concerto_cms_core_navigation"
            )
        );

    }
}
