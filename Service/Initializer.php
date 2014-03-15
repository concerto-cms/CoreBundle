<?php
/**
 * Created by PhpStorm.
 * User: mathieu
 * Date: 07/02/14
 * Time: 22:36
 */

namespace ConcertoCms\CoreBundle\Service;


use Doctrine\Bundle\PHPCRBundle\Initializer\InitializerInterface;
use PHPCR\SessionInterface;

class Initializer implements InitializerInterface
{

    /**
     * @var \ConcertoCms\CoreBundle\Service\Content
     */
    private $cm;

    /**
     * @param $cm \ConcertoCms\CoreBundle\Service\Content
     */
    public function __construct($cm)
    {
        $this->cm = $cm;
    }

    /**
     * Initialize the session for the bundle providing this service.
     *
     * If nodes are added, $session->save() must be called as the init command
     * does not do that.
     *
     * @param SessionInterface $session
     */
    public function init(SessionInterface $session)
    {
        /*
        if (!$session->nodeExists("/cms/routes")) {
            $this->cm->initializeRoute();
        }
        */
    }
}
