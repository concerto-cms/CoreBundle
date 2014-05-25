<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 25/05/14
 * Time: 22:08
 */
namespace ConcertoCms\CoreBundle\Menu;

use ConcertoCms\CoreBundle\Event\MenuEvent;

class MainMenuBuilder
{
    /**
     * @var \Knp\Menu\MenuFactory
     */
    private $factory;
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $dispatcher;

    public function __construct($dispatcher, $factory)
    {

        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
    }

    public function build()
    {
        $root = $this->factory->createItem("TopMenu");
        $event = new MenuEvent($root);
        $this->dispatcher->dispatch("concerto.menu.main.build", $event);
        return $root;
    }
}
