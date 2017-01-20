<?php

// src/BaseBundle/Controller/ContactController.php
namespace BaseBundle\Controller;

use BaseBundle\Entity\Contact;
use BaseBundle\Form\Contact\contactForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function contactAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $contact = new Contact();

        // Hydrater le formulaire avant de l'afficher
        //$contact->setNom("Lannister");
        //$contact->setPrenom("Joffrey");
        //$contact->setMail("jl@test.com");
        //$contact->setDemande("Merde !");

        // Hydrater le formulaire avant de l'afficher avec un objet contact de la bdd
        //$contact = $this->getDoctrine()->getRepository('AppBundle:Contact')->find(1);
        
        //$contact->setId(4); ou null ou 0 : insuffisant pour créer une nouvelle entrée, réalise un update
        // Pour réaliser une copie
        /*$contact2 = new Contact();
        $contact2->setNom($contact->getNom());
        $contact2->setPrenom($contact->getPrenom());
        $contact2->setMail($contact->getMail());
        $contact2->setDemande($contact->getDemande());*/

        /* Déclaration ds contrôlleur, préférer la déclaration ds une classe réutilisable
        $form = $this->createFormBuilder($Contact)
            //->add('task', TextType::class)
            //->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();
        */

        $form = $this->createForm(contactForm::class, $contact);
        $form->handleRequest($request); // True if the form was submitted, false for the first page call        

        // Si le formulaire à été validé
        if ($form->isSubmitted() && $form->isValid()) // { Applique les validations (de base et/ou celles se trouvant dans appBundle/Ressources/Config/validation.yml associés à l'objet)
        {
            //$request->request->get('nom');
            //$data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('base_homepage'); //nom ds routing.yml
            //return $this->redirect($this->generateUrl('base_homepage'), 301);
        }

        // if subject charger les sousMotif
        if (NULL != $contact->getSubject())
        {
            $choices = null;

            $Em = $this->getDoctrine()->getManager();
            $conn = $Em->getConnection();

            $sql = 'SELECT * FROM contact';
            $stmt = $conn->prepare($sql);
            $choices = $stmt->execute();
        }


        //php
            //return $this->render('MainBundle:Contact:contactPage.html.php', array('contactForm' => $form->createView(),));
        //twig
            return $this->render('BaseBundle:Contact:contactPage.html.twig', array('contactForm' => $form->createView(),));
    }
}