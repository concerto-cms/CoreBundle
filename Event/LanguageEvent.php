<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 20:20
 */

namespace ConcertoCms\CoreBundle\Event;


use ConcertoCms\CoreBundle\Document\LanguageRoute;
use Symfony\Component\EventDispatcher\Event;

class LanguageEvent extends Event
{
    private $language;

    /**
     * @param LanguageRoute $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return LanguageRoute
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
