<?php
namespace ConcertoCms\CoreBundle;

use ConcertoCms\CoreBundle\DependencyInjection\ExtensionsCompilerPass;
use ConcertoCms\CoreBundle\DependencyInjection\PageManagerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ConcertoCmsCoreBundle
 * @package ConcertoCms\CoreBundle
 */
class ConcertoCmsCoreBundle extends Bundle
{
    /**
     * @inherit
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new PageManagerCompilerPass());
    }
}
