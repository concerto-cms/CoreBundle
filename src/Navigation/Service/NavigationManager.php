<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:41
 */
namespace ConcertoCms\CoreBundle\Navigation\Service;

use ConcertoCms\CoreBundle\Document\LanguageRoute;
use ConcertoCms\CoreBundle\Languages\Service\LanguagesManager;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;

class NavigationManager
{
    use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;

    private $lm;
    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     * @param $lm LanguagesManager
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm,
    LanguagesManager $lm
    ) {
        $this->setDocumentManager($dm);
        $this->lm = $lm;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $root = $this->dm->find(null, "/cms/menu");
        return $root->getChildren()->toArray();
    }

    public function getByUrl($path)
    {
        $url = "/cms/menu/" . ltrim($path, "/");
        $url = rtrim($url, "/");
        return $this->dm->find(null, $url);
    }

    public function syncLanguages()
    {
        $menus = $this->getAll();
        $languages = $this->lm->getAll();

        /**
         * @var $menu Menu
         */
        foreach ($menus as $menu) {
            $menuLanguages = $menu->getChildren();
            /**
             * @var $language LanguageRoute
             */
            foreach ($languages as $language) {
                // see if it exists
                $languageExists = false;
                foreach ($menuLanguages as $node) {
                    if ($node->getName() == $language->getName()) {
                        $languageExists = true;
                        $node->setName($language->getName());
                        $node->setLabel($language->getDescription());
                        break;
                    }
                }
                if (!$languageExists) {
                    $node = new MenuNode();
                    $node->setParentDocument($menu);
                    $node->setName($language->getName());
                    $node->setLabel($language->getDescription());
                    $this->persist($node);
                }
            }
        }
    }

    /**
     * @param $id string
     * @param $locale string
     * @return null|Menu
     */
    public function getMenu($id, $locale = null)
    {
        $id = rtrim($id, "/");
        if ($locale) {
            return $this->dm->find(null, "/cms/menu/" . $id . "/" . $locale);
        }
        return $this->dm->find(null, "/cms/menu/" . $id);
    }

    public function reorder(MenuNode $menu, $beforePath)
    {
        $parent = $menu->getParentDocument();
        $this->dm->reorder($parent, $menu->getName(), basename($beforePath), false);
        $this->dm->flush();
    }


    /**
     * @param Menu $menu
     */
    public function addMenu($menu)
    {
        $parent = $this->dm->find(null, "/cms/menu");
        $menu->setParentDocument($parent);
        $this->dm->persist($menu);
        $this->dm->flush();

        $this->syncLanguages();
    }

    /**
     * @param string $menuName
     * @param string $locale
     * @param string $parentName
     * @param MenuNode $item
     */
    public function addMenuItem($menuName, $locale, $parentName, MenuNode $item)
    {
        $this->syncLanguages();
        if ($parentName == "/") {
            $parentName = "";
        }
        $parentName = "/" . ltrim($parentName, "/");
        $menu = $this->getMenu($menuName, $locale);
        $parentUrl = rtrim($menu->getId() . $parentName, "/");

        $parent = $this->dm->find(null, $parentUrl);
        $item->setParentDocument($parent);
        $this->persist($item);
    }

}
