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

    /**
     * @param $id string
     */
    public function getMenus()
    {
        $node = $this->dm->find(null, "/cms/menu");
        return $node->getChildren();
    }

    /**
     * @param MenuNode $menu
     */
    public function addMenu($menu)
    {
        $parent = $this->dm->find(null, "/cms/menu");
        $menu->setParent($parent);
        $this->dm->persist($menu);
        $this->dm->flush();
    }

    public function save($object)
    {
        $this->dm->persist($object);
        $this->dm->flush();
    }

    public function onLanguageAdd(LanguageEvent $event)
    {

        throw new NotImplementedException("Hey, you can't do that!!");

    }

} 