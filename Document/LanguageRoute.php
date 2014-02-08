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
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * @PHPCR\Document(referenceable=true)
 */
class LanguageRoute extends Route
{
    private $prefix;
    private $isoCode;
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
}
