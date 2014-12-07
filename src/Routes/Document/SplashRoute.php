<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 05/02/14
 * Time: 22:11
 */

namespace ConcertoCms\CoreBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(referenceable=true)
 */
class SplashRoute extends Route
{
}
