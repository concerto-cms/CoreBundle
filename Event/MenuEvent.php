<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 25/05/14
 * Time: 22:16
 */

namespace ConcertoCms\CoreBundle\Event;

use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\Event;

class MenuEvent extends Event
{
    /**
     * @var MenuItem
     */
    private $rootMenu;

    public function __construct(MenuItem $root)
    {
        $this->rootMenu = $root;
    }

    /**
     * @param mixed $child   An ItemInterface instance or the name of a new item to create
     * @param array $options If creating a new item, the options passed to the factory for the item
     * @return \Knp\Menu\ItemInterface
     */
    public function addChild($child, array $options = array())
    {
        return $this->rootMenu->addChild($child, $options);
    }
}
