<?php

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    public function homePageAction()
    {
        return $this->render('BaseBundle:HomePage:homePage.html.twig');
    }
}
