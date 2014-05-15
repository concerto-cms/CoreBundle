<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 09:32
 */

namespace ConcertoCms\CoreBundle\DependencyInjection;

use Knp\Menu\MenuFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class ExtensionsCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('concerto_cms_core.extension_container')) {
            return;
        }

        $definition = $container->getDefinition(
            'concerto_cms_core.extension_container'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'concerto.extension'
        );

        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addExtension',
                array(new Reference($id))
            );
        }
    }
}
