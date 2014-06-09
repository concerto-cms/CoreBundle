<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 08/02/14
 * Time: 08:51
 */

namespace ConcertoCms\CoreBundle\Model;


class Locale implements \JsonSerializable
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

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array(
            "name" => $this->getName(),
            "prefix" => $this->getPrefix(),
            "isoCode" => $this->getIsoCode()
        );
    }
}
