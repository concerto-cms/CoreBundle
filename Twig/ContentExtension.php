<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 18/05/14
 * Time: 15:50
 */
namespace ConcertoCms\CoreBundle\Twig;

use ConcertoCms\CoreBundle\Extension\PageManagerContainer;
use ConcertoCms\CoreBundle\Service\Content;

class ContentExtension extends \Twig_Extension
{
    private $pagemanager;
    public function __construct(PageManagerContainer $pagemanager)
    {
        $this->pagemanager = $pagemanager;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "concerto_core_content";
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getPagetypes', array($this, 'pagetypesFunction')),
        );
    }

    public function pagetypesFunction()
    {
        return $this->pagemanager->getPagetypes();
    }
}
