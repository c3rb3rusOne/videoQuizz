<?php

// src/BaseBundle/Controller/RegisterController.php
namespace BaseBundle\Controller;

use BaseBundle\Entity\User;
use BaseBundle\Event\UserCreatedEvent;
use BaseBundle\Forms\UserForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// For method 2
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class RegisterController extends Controller
{
    public function RegisterAction(Request $request) //RegisterAction -> min et maj acceptés
    {
        $user = new User();

        //get a user avec le nom ou l'id de l'utilisateur connecté si besoin d'update (ou récup user en session ?)
        //$contact = $this->getDoctrine()->getRepository('BaseBundle:Contact')->find(1);

        $form = $this->createForm(UserForm::class, $user);

        // Méthode 1 : si non admin -> suppression de champs du formulaire (fonctionne)
        //if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) //NON ! ADMIN à AUSSI les droits USER
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $form->remove('isActive');
            $form->remove('roles');
        }

        // Méthode 2 : si admin -> ajout de champs au formulaire (! par défaut ajout à la FIN du formulaire, après bouton submit)
        /*if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) //ROLE_ADMIN
        {
            $form->remove('submit');

            //roles champs array pr login, string pr doctrine
            $form->add('roles', ChoiceType::class, array(
                    'choices' => array(
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ),
                'label'  => 'form.roles.label',
                //false impossible à cause de l'intégration des outils symfony de login, pour cela:
                //- Change the entity fields: roles -> role, type string - getRole() & setRole()
                //- public function getRoles() { return array($this->role); }
                'multiple' => true,
                'expanded' => true,
                'choices_as_values' => true,
                'data' => array('ROLE_USER')
            ));

            $form->add('submit', SubmitType::class, array('label'  => 'form.submit.label'));
        }*/

        $form->handleRequest($request);

        // Si le formulaire à été validé
        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            //$data = $request->request->all();
            //$roles = $data['UserForm']['roles'];
            //$form->getClientData();
            //$postData = $request->request->get('roles');
            //$name_value = $postData['name'];

            //$user->setRoles($roles[0]); // Si string en bdd

            // Si l'utilisateur n'est pas admin ou que roles est à null set 'ROLE_USER'
            if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
            {
                $user->setRoles(array('ROLE_USER'));
                $user->setIsActive(false);
            }
            else
            {
                if (empty($user->getRoles()))
                    $user->setRoles(array('ROLE_USER'));
                if (empty($user->getIsActive()))
                    $user->setIsActive(false);
            }

            if (false == $user->getIsActive())
            {
                $token = $this->generateToken();
                $user->setEmailConfirmationToken($token);

                // Evènement besoin de confirmer l'adresse mail
                $urlValidation = $this->get('router')->generate('base_confirm_email', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                // On crée l'évènement
                $event = new UserCreatedEvent($user->getMail(), $urlValidation);
                // On déclenche l'évènement
                $this->get('event_dispatcher')->dispatch('base.event.user_created', $event);
                // On récupère ce qui a été modifié par le ou les listeners, ici le message
                //$xxx = $event->getXXX();
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('base_homepage');
        }

        return $this->render('BaseBundle:UserManagement:Register.html.twig', array('UserForm' => $form->createView(),));
    }

    public function ConfirmAction(Request $request, $token)
    {
        // Récupérer l'utilisateur via son token
        //$user = $this->getDoctrine()->getRepository('BaseBundle:User')->findOneByEmailConfirmationToken($token);
        $em = $this->getDoctrine()->getEntityManager(); // ou getManager() ?
        $user = $em->getRepository('BaseBundle:User')->findOneByEmailConfirmationToken($token);

        if (!$user)
            throw $this->createNotFoundException('User don\'t exist');

        print($user->getMail());

        // Sinon l'activer
        $user->setEmailConfirmationToken(null);
        $user->setIsActive(true);

        //$dispatcher = $this->get('event_dispatcher'); // or $dispatcher = new EventDispatcher(); ? -> non
        //$event = new GetResponseUserEvent($user, $request);
        //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        // Update $user
        $em->flush();

        /*if (null === $response = $event->getResponse())
        {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));
        */
        return $this->redirectToRoute('homepage');
    }

    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}