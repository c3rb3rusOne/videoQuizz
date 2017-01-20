<?php
// src/BaseBundle/Controller/SecurityController.php
// Utilisé pour la connexion des utilisateurs, dans une gestion native (sans FOSUserBundle)

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BaseBundle\Form\Login\loginForm;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //$user = new User(); // -> optionnel (UNIQUEMENT PR LE LOGIN) (permet de pré-remplir les champs, faire un update... UNIQUEMENT PR LE LOGIN)
        $form = $this->createForm(loginForm::class);
        //$form = $this->createForm(loginForm::class, $user, array('action' => $this->generateUrl('login'), 'method' => 'POST', ));

        // $lastUsername = last username entered by the user
        //return $this->render('security/login.html.twig', array('last_username' => $lastUsername, 'error' => $error, ));
        return $this->render('security/login.html.twig', array('loginForm' => $form->createView(), 'last_username' => $lastUsername, 'error' => $error, ));

        //si auth balancer index ou page précédemment demandée
    }
}