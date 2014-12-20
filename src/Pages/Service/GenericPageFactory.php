<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 19/12/2014
 * Time: 22:00
 */

namespace ConcertoCms\CoreBundle\Pages\Service;


use ConcertoCms\CoreBundle\Pages\PageFactoryInterface;
use JMS\Serializer\Serializer;

class GenericPageFactory implements PageFactoryInterface {
    private $serializer;
    private $pageFQN;
    public function __construct(Serializer $serializer, $fqn) {
        $this->serializer = $serializer;
        $this->pageFQN = $fqn;
    }

    public function createFromJson($data)
    {
        $this->serializer->deserialize(json_encode($data), $this->getPageFQN(), "json");
    }

    public function updateFromJson($page, $data)
    {
        // Create a deserialization context, targeting the existing user
        $context = new \JMS\Serializer\DeserializationContext();
        $context->attributes->set('target', $page);

        // Deserialize the data "on to" to the existing user
        $this->serializer->deserialize(json_encode($data), 'MyApp\Model\User', 'json', $context);
    }

    public function getPageFQN()
    {
        return $this->pageFQN;
    }

} 