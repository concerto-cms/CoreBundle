<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 13/12/2014
 * Time: 15:40
 */

namespace ConcertoCms\CoreBundle\Pages\Service;


use ConcertoCms\CoreBundle\Pages\Exception\FactoryNotFoundException;
use ConcertoCms\CoreBundle\Pages\PageFactoryInterface;
use ConcertoCms\CoreBundle\Util\PublishableInterface;

class PageFactoryRepository  {
    private $factories = [];
    private $entityClasses = [];

    /**
     * @param $name
     * @param PageFactoryInterface $factory
     */
    public function addFactory($name, PageFactoryInterface $factory) {
        $this->factories[$name] = $factory;
        $this->entityClasses[$factory->getPageFQN()] = $factory;
    }

    /**
     * @param $name
     * @return PageFactoryInterface
     * @throws FactoryNotFoundException
     */
    public function getByName($name) {

        if (isset($this->factories[$name])) {
            return $this->factories[$name];
        } else {
            throw new FactoryNotFoundException("Couldn't find factory for " . $name);
        }
    }

    /**
     * @param PublishableInterface $page
     * @throws FactoryNotFoundException
     * @return PageFactoryInterface
     */
    public function getByPage(PublishableInterface $page) {
        $fqn = get_class($page);
        if (isset($this->entityClasses[$fqn])) {
            return $this->entityClasses[$fqn];
        } else {
            throw new FactoryNotFoundException("Couldn't find factory for " . $fqn);
        }
    }

} 