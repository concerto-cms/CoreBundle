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

class RepositoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('concerto_cms_core.content')) {
            return;
        }

        $definition = $container->getDefinition(
            'concerto_cms_core.content'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'concerto.repository'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addRepository',
                array(new Reference($id))
            );
        }
    }
}
