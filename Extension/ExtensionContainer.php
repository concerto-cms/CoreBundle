<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 12/05/14
 * Time: 22:15
 */

namespace ConcertoCms\CoreBundle\Extension;

use Knp\Menu\MenuFactory;

class ExtensionContainer
{
    private $extensions;
    private $factory;

    public function __construct($factory)
    {
        $this->factory = $factory;
        $this->extensions = array();
    }

    public function addExtension(ConcertoExtension $ext)
    {
        $this->extensions[] = $ext;
    }

    public function buildTopMenu()
    {
        $root = $this->factory->createItem("TopMenu");
        /**
         * @var $extension \ConcertoCms\CoreBundle\Extension\ConcertoExtension
         */
        foreach ($this->extensions as $extension) {
            $extension->buildTopMenu($root);
        }
        return $root;
    }

}
