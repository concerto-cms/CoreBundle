<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 29/05/14
 * Time: 08:19
 */

namespace ConcertoCms\CoreBundle\Extension;


class PageType implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $jsView;
    /**
     * @var string
     */
    private $label;
    /**
     * @var array|null
     */
    private $allowedChildTypes;

    /**
     * @var bool
     */
    private $showInList = true;

    public function __construct($name = "", $label = "", $jsView = "", $showInList = true, $allowedChildTypes = null)
    {
        $this->allowedChildTypes = $allowedChildTypes;
        $this->jsView = $jsView;
        $this->label = $label;
        $this->name = $name;
        $this->showInList = $showInList;
    }

    /**
     * @param array|null $allowedChildTypes
     */
    public function setAllowedChildTypes($allowedChildTypes)
    {
        $this->allowedChildTypes = $allowedChildTypes;
    }

    /**
     * @return array
     */
    public function getAllowedChildTypes()
    {
        return $this->allowedChildTypes;
    }

    /**
     * @param string $jsView
     */
    public function setJsView($jsView)
    {
        $this->jsView = $jsView;
    }

    /**
     * @return string
     */
    public function getJsView()
    {
        return $this->jsView;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $showInList
     */
    public function setShowInList($showInList)
    {
        $this->showInList = $showInList;
    }

    /**
     * @return boolean
     */
    public function getShowInList()
    {
        return $this->showInList;
    }

    public function jsonSerialize()
    {
        return array(
            "name" => $this->getName(),
            "label" => $this->getLabel(),
            "jsView" => $this->getJsView(),
            "allowedChildTypes" => $this->getAllowedChildTypes(),
            "showInList" => $this->showInList
        );
    }
}
