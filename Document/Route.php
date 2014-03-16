<?php
namespace ConcertoCms\CoreBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Route extends \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route implements RouteInterface {
    public function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "content" => $this->getContent()->jsonSerialize(),
            "parent" => $this->getParent()->getId()
        );
    }
}