<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 09:32
 */

namespace ConcertoCms\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class PageManagerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('concerto_cms_core.pagemanager_container')) {
            throw new \RuntimeException("Couldn't find service concerto_cms_core.pagemanager_container");
        }

        $definition = $container->getDefinition(
            'concerto_cms_core.pagemanager_container'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'concerto.pagemanager'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addManager',
                array(new Reference($id))
            );
        }
    }
}
