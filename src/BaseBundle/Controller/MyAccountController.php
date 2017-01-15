<?php

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyAccountController extends Controller
{
    public function myAccountAction()
    {
        return $this->render('BaseBundle:UserManagement:myAccount.html.twig');
    }
}
