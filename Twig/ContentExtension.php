<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 18/05/14
 * Time: 15:50
 */

namespace ConcertoCms\CoreBundle\Twig;


use ConcertoCms\CoreBundle\Service\Content;

class ContentExtension extends \Twig_Extension {
    private $contentService;
    function __construct(Content $contentService)
    {
        $this->contentService = $contentService;
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
        return $this->contentService->getPagetypes();

    }

} 