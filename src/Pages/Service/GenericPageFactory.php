<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 19/12/2014
 * Time: 22:00
 */

namespace ConcertoCms\CoreBundle\Pages\Service;


use ConcertoCms\CoreBundle\Pages\PageFactoryInterface;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class GenericPageFactory implements PageFactoryInterface {
    private $serializer;
    private $pageFQN;
    private $dm;
    public function __construct(DocumentManager $dm, $fqn) {
        $this->dm = $dm;
        $this->pageFQN = $fqn;
    }

    public function createFromJson($data)
    {
        $type = $this->getPageFQN();
        $page = new $type();
        $this->updateFromJson($page, $data);
        return $page;

   //     return $this->serializer->deserialize(json_encode($data), $this->getPageFQN(), "json");
    }

    public function updateFromJson($page, $data)
    {
        // Create a deserialization context, targeting the existing user
        if (get_class($page) !== $this->pageFQN) {
            throw new \RuntimeException("given page doesn't match the factory's page FQN");
        }
        $metadata = $this->dm->getClassMetadata(get_class($page));
        foreach ($data as $key => $value) {
            if ($metadata->hasField($key)) {
                $metadata->setFieldValue($page, $key, $value);
            }
        }
        return $page;
    }

    public function getPageFQN()
    {
        return $this->pageFQN;
    }
}
