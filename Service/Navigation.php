<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 15:56
 */

namespace ConcertoCms\CoreBundle\Service;

use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Event\LanguageEvent;
use ConcertoCms\CoreBundle\Model\Locale;
use ConcertoCms\CoreBundle\Document\Route;
use ConcertoCms\CoreBundle\Document\ContentInterface;
use Jackalope\NotImplementedException;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;

class Navigation {
    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    private $dm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(\Doctrine\ODM\PHPCR\DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @param $id string
     * @return null|Menu
     */
    public function getMenu($id)
    {
        return $this->dm->find(null, "/cms/menu/" . $id);
    }

    public function getMenuLocale($id, $locale)
    {
        return $this->dm->find(null, "/cms/menu/" . $id . "/" . $locale);
    }

    public function getMenus()
    {
        $node = $this->dm->find(null, "/cms/menu");
        return $node->getChildren();
    }

    /**
     * @param Menu $menu
     */
    public function addMenu($menu)
    {
        $parent = $this->dm->find(null, "/cms/menu");
        $menu->setParent($parent);
        $this->dm->persist($menu);
        $this->dm->flush();

        $languages = $this->dm->find(null, "/cms/routes");
        foreach($languages->getChildren() as $lang) {
            $this->addLanguageToMenu($menu, $lang);
        }

    }

    /**
     * @param string $menuName
     * @param string $locale
     * @param string $parentName
     * @param MenuNode $item
     */
    public function addMenuItem($menuName, $locale, $parentName, MenuNode $item)
    {
        if ($parentName == "/")
            $parentName = "";
        $menu = $this->getMenuLocale($menuName, $locale);

        $parent = $this->dm->find(null, $menu->getId() . $parentName);
        $item->setParent($parent);
        $this->save($item);
    }

    public function save($object)
    {
        $this->dm->persist($object);
        $this->dm->flush();
    }

    public function onLanguageAdd(LanguageEvent $event)
    {
        $route = $event->getLanguage();
        $menus = $this->getMenus();
        /**
         * @var $menu Menu
         */
        foreach ($menus as $menu) {
            $this->addLanguageToMenu($menu, $route);
        }
    }
    private function addLanguageToMenu(Menu $menu, LanguageRoute $route)
    {
        $lang = new MenuNode();
        $lang->setParent($menu);
        $lang->setName($route->getLocale()->getPrefix());
        $lang->setLabel($route->getLocale()->getName());
        $this->save($lang);
    }

} 