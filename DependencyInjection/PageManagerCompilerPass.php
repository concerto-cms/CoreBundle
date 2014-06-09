<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 11/05/14
 * Time: 09:32
 */

namespace ConcertoCms\CoreBundle\DependencyInjection;

use ConcertoCms\CoreBundle\Extension\PageManagerContainer;
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

        $container_definition = $container->getDefinition(
            'concerto_cms_core.pagemanager_container'
        );

        if ($container->hasDefinition("event_dispatcher")) {
            $dispatcher_definition = $container->getDefinition(
                'event_dispatcher'
            );
        } elseif ($container->hasDefinition("debug.event_dispatcher")) {
            $dispatcher_definition = $container->getDefinition(
                'debug.event_dispatcher'
            );
        } else {
            throw new \RuntimeException("Couldn't find event dispatcher");
        }

        $taggedServices = $container->findTaggedServiceIds(
            'concerto.pagemanager'
        );

        foreach ($taggedServices as $id => $attributes) {
            $reference = new Reference($id);
            //$this->dispatcher->addListener(self::CREATE_EVENT, array($service, "onCreate"));
            //$this->dispatcher->addListener(self::POPULATE_EVENT, array($service, "onPopulate"));
            $dispatcher_definition->addMethodCall(
                "addListener",
                array(
                    PageManagerContainer::CREATE_EVENT,
                    array($reference, "onCreate")
                )
            );
            $dispatcher_definition->addMethodCall(
                "addListener",
                array(
                    PageManagerContainer::POPULATE_EVENT,
                    array($reference, "onPopulate")
                )
            );

            $container_definition->addMethodCall(
                'addManager',
                array($reference)
            );
        }
    }
}
