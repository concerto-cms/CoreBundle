<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 12/05/14
 * Time: 21:45
 */

namespace ConcertoCms\CoreBundle\Service;

use ConcertoCms\CoreBundle\Extension\ConcertoExtension;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;

/**
 * Class Extension
 * @package ConcertoCms\CoreBundle\Service
 */
class Extension extends ConcertoExtension
{
    public function __construct()
    {
    }

    public function buildTopMenu(MenuItem $root)
    {
        $content = $root->addChild(
            "Content",
            array(
                'route' => 'concerto_cms_core_content_rest'
            )
        );
    }
}
