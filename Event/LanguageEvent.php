<?php
/**
 * Created by PhpStorm.
 * User: Mathieu
 * Date: 19/04/14
 * Time: 20:20
 */

namespace ConcertoCms\CoreBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class LanguageEvent extends Event {
    private $language;

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

} 