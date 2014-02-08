<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 08/02/14
 * Time: 08:51
 */

namespace ConcertoCms\CoreBundle\Model;


class Locale
{
    private $prefix;
    private $isoCode;
    private $name;

    public function __construct($isoCode, $name, $prefix)
    {
        $this->isoCode = $isoCode;
        $this->name = $name;
        $this->prefix = $prefix;
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

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
