<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/12/2014
 * Time: 14:00
 */
namespace ConcertoCms\CoreBundle\Pages\Controller;

class PagesController {
    use \ConcertoCms\CoreBundle\Util\JsonApiTrait;

    private $pm;
    private $rm;

    public function __construct(PagesManager $pm, RoutesManager $rm) {

    }

    public function getAction() {

    }

} 