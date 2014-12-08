<?php
namespace ConcertoCms\CoreBundle\Document;

use ConcertoCms\CoreBundle\Util\RouteInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class Route extends \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route implements RouteInterface
{
    public function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "slug" => $this->getName(),
            "parent" => $this->getParentDocument()->getId()
        );
    }
}
