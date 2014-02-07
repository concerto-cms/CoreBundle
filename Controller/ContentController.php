<?php
namespace ConcertoCms\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContentController extends Controller
{
    public function indexAction()
    {
        return $this->render('ConcertoCmsCoreBundle:Content:index.html.twig');

    }
}
