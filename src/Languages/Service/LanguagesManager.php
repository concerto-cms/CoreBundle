<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 15:38
 */

namespace ConcertoCms\CoreBundle\Languages\Menu;
use \ConcertoCms\CoreBundle\Util\DocumentManagerTrait;


class LanguagesManager {
    /**
     * @param $dm \Doctrine\ODM\PHPCR\DocumentManager
     */
    public function __construct(
        \Doctrine\ODM\PHPCR\DocumentManager $dm
    ) {
        $this->setDocumentManager($dm);
    }

} 