<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 11:47
 */

namespace ConcertoCms\CoreBundle\Util;

trait DocumentManagerTrait
{
    /**
     * @var \Doctrine\ODM\PHPCR\DocumentManager
     */
    private $dm;

    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    protected function setDocumentManager($dm)
    {
        $this->dm = $dm;
    }

    /**
     * @returns \Doctrine\ODM\PHPCR\DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->dm;
    }

    public function persist($document)
    {
        $this->dm->persist($document);
    }

    public function flush()
    {
        $this->dm->flush();
    }

    public function remove($document)
    {
        $this->dm->remove($document);
    }

    public function clear()
    {
        $this->dm->clear();
    }

}
