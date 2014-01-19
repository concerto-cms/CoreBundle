<?php

namespace ConcertoCms\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ConcertoCmsCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
