<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 19/12/2014
 * Time: 22:44
 */

namespace ConcertoCms\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PageManagerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('concerto_cms_core.pages.service.page_factory_repository')) {
            throw new \RuntimeException(
                "Couldn't find service concerto_cms_core.pages.service.page_factory_repository"
            );
        }

        $repository_definition = $container->getDefinition(
            'concerto_cms_core.pages.service.page_factory_repository'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'concerto.pagefactory'
        );

        foreach ($taggedServices as $id => $attributes) {
            $reference = new Reference($id);
            $name = $id;
            if (isset($attributes[0]["alias"])) {
                $name = $attributes[0]["alias"];
            }

            //$this->dispatcher->addListener(self::CREATE_EVENT, array($service, "onCreate"));
            //$this->dispatcher->addListener(self::POPULATE_EVENT, array($service, "onPopulate"));

            //addFactory($name, PageFactoryInterface $factory)
            $repository_definition->addMethodCall(
                "addFactory",
                array($name, $reference)
            );
        }
    }
}
