<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:42
 */
namespace ConcertoCms\CoreBundle\Pages\Service;

class PagesManager {
    use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;


    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm
    ) {
        $this->setDocumentManager($dm);
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
        $parentPage = $this->getPage($parentUrl);
        if (!$parentPage) {
            throw new \InvalidArgumentException("Couldn't find parent page with url " . $parentUrl);
        }

        // Create a new Page using the pagemanager events
        $createEvent = new Event\PageCreateEvent($type);
        $this->dispatcher->dispatch(PageManagerContainer::CREATE_EVENT, $createEvent);


        $page = $createEvent->getDocument();
        if ($page == null) {
            throw new \UnexpectedValueException(
                "Document was not created after dispatching event"
            );
        }

        $page->setParent($parentPage);

        // If there are params, perform populate as well
        if (count($params)) {
            $this->populate($page, $params);
        }

        $this->persist($page);
        $route = $this->createRoute($parentUrl, $page);
        return $route;
    }
}
