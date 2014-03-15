<?php
namespace ConcertoCms\CoreBundle\Document;

class Route extends \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route implements RouteInterface {
    public function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "name" => $this->getName(),
            "content" => $this->getContent()->jsonSerialize()
        );
    }
}