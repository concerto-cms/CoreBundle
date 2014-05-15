<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 12/05/14
 * Time: 21:43
 */

namespace ConcertoCms\CoreBundle\Extension;

use Knp\Menu\MenuItem;

/**
 * Class ConcertoExtension
 * @package ConcertoCms\CoreBundle
 */
abstract class ConcertoExtension
{
    public function buildTopMenu(MenuItem $root)
    {
    }
}
