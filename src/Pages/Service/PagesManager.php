<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:42
 */
namespace ConcertoCms\CoreBundle\Pages\Service;

use ConcertoCms\CoreBundle\Document\SplashRoute;
use ConcertoCms\CoreBundle\Pages\Event\PageCreateEvent;
use ConcertoCms\CoreBundle\Pages\Event\PageUpdateEvent;
use ConcertoCms\CoreBundle\Routes\Service\RoutesManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PagesManager
{
    use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;

    private $rm;
    private $factory;
    private $dispatcher;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm,
        RoutesManager $rm,
        PageFactoryRepository $factory,
        EventDispatcherInterface $dispatcher
    ) {
        $this->setDocumentManager($dm);
        $this->rm = $rm;
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $url string
     * @return null|ContentInterface
     */
    public function getByUrl($url)
    {
        $url = "/cms/pages/" . ltrim($url, "/");

        $url = rtrim($url, "/");
        return $this->dm->find(null, $url);
    }

    public function getSplash()
    {
        $splash = $this->getByUrl("");
        return $splash;
    }

    /**
     * @param $parentUrl string
     * @param $params array
     */
    public function createPage($parentUrl, $type, $params = array())
    {
        $parentPage = $this->getByUrl($parentUrl);
        if (!$parentPage) {
            throw new \InvalidArgumentException("Couldn't find parent page with url " . $parentUrl);
        }
        $parentRoute = $this->rm->getByUrl($parentUrl);
        if (!$parentRoute) {
            throw new \InvalidArgumentException("Couldn't find parent route with url " . $parentUrl);
        }
        if ($parentRoute instanceof SplashRoute) {
            throw new \InvalidArgumentException("Can't create a page here");
        }

        /**
         * @todo: Check if route already exists
         */
        //var_dump($parentRoute->getChildren()->getKeys());
        //die();


        $factory = $this->factory->getByName($type);
        $page = $factory->createFromJson($params);

        if ($page == null) {
            throw new \UnexpectedValueException(
                "Document was not created after dispatching event"
            );
        }
        $page->setParent($parentPage);
        $this->persist($page);
        $event = new PageCreateEvent();
        $event->setPage($page);
        $event->setParams($params);
        $this->dispatcher->dispatch("concerto.pages.create", $event);
        $this->rm->createRoute($parentUrl, $page);
        return $page;
    }

    public function update($page, $params)
    {
        $factory = $this->factory->getByPage($page);
        $factory->updateFromJson($page, $params);

        $event = new PageUpdateEvent();
        $event->setPage($page);
        $event->setParams($params);
        $this->dispatcher->dispatch("concerto.pages.update", $event);

        return $page;
    }

    public function delete($page)
    {
        $children = $page->getChildren();
        foreach ($children as $child) {
            $this->delete($child);
        }
        foreach ($page->getRoutes() as $route) {
            $this->rm->delete($route);
        }
        $this->getDocumentManager()->remove($page);

    }
}
