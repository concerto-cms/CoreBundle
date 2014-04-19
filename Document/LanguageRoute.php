<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 08/02/14
 * Time: 08:45
 */

namespace ConcertoCms\CoreBundle\Document;

use ConcertoCms\CoreBundle\Model\Locale;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class LanguageRoute extends Route
{
    /**
     * @PHPCR\String(nullable=false)
     */
    private $isoCode;
    /**
     * @PHPCR\String(nullable=false)
     */
    private $description;

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function getLocale()
    {
        return new Locale($this->getIsoCode(), $this->getDescription(), $this->getName());
    }

    public function setLocale(Locale $locale)
    {
        $this->setDefault("_locale", $locale->getPrefix());
        $this->setDescription($locale->getName());
        $this->setName($locale->getPrefix());
        $this->setIsoCode($locale->getIsoCode());
    }

    /**
     * @param mixed $isoCode
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;
    }

    /**
     * @return mixed
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    public function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "isoCode" => $this->getIsoCode(),
            "description" => $this->getDescription(),
            "name" => $this->getName(),
            "content" => $this->getContent()->jsonSerialize(),
            "parent" => $this->getParent()->getId()

        );
    }
}
