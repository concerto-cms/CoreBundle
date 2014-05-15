<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 12/05/14
 * Time: 21:51
 */

namespace ConcertoCms\CoreBundle\Service\Menu;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\TwigRenderer;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class TopMenu
 * @package ConcertoCms\CoreBundle\Service\Menu
 */
class TopMenu
{
    private $factory;
    private $menu;

    public function __construct()
    {
        $this->factory = new MenuFactory();
        $this->menu = $this->factory->createItem("Topmenu");

    }

    public function render()
    {

    }

} 