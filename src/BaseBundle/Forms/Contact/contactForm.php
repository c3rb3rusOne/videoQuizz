<?php

// src/BaseBundle/Form/Contact.php
namespace BaseBundle\Forms\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use BaseBundle\Forms\Type\DemandeType; // Custom field
//use BaseBundle\ContactSubjectChoiceLoader;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class contactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'label' => 'form.name.label','attr' => array('help' => 'text helppppppp')))
            ->add('first_name', TextType::class, array('required' => true, 'label' => 'form.first_name.label')) # 'translation_domain' => 'validators' Plutôt dans resolver si configureOptions est présent 
            ->add('mail', EmailType::class, array('required' => true, 'label'  => 'form.mail.label')) // 1er = nom : pas d'espace, carac spé etc (utilisé pr label si celui-ci n'est pas précisé et si l'option auto label activée)
            ->add('subject', ChoiceType::class, array(
                'choices' => array(
                'form.choiceOther.label' => 'form.choiceOther.label',
                'form.choiceOther2.label' => 'form.choiceOther2.label',
                ),
                'label' => 'form.reason.label',
                //If set to true, radio buttons or checkboxes will be rendered (depending on the multiple value). If false, a select element will be rendered.
                'expanded' => false,
                'multiple' => false,
            ))
            ->add('sousMotif', ChoiceType::class, array(
            /*        // The choice_loader can be used to only partially load the choices in cases where a fully-loaded list is not necessary. This is only needed in advanced cases and would replace the choices option.
                    'choices' => array(
                    'ChoisissezInit' => 'ChoisissezInit',
                    'Autre' => 'Autre',
                ),
                //'choice_loader' => new ContactSubjectChoiceLoader($this),
                'label' => 'form.secondReason.label',
                'expanded' => false,
                'multiple' => false,*/
            ))
            ->add('request', DemandeType::class, array('required' => true, 'label'  => 'form.request.label')) 
            //->add('dueDate', null, array('widget' => 'single_text'))
            ->add('submit', SubmitType::class, array('label'  => 'form.submit.label'));
        ;

            // Si pas désactivé ou surdéfini la vérification des champs (type mail date...) est auto.

        // For dynamically change the value of sousMotif when the value of subject change.
        $formModifier = function (/*FormInterface*/ $form, $subject = null) {
            $sousMotifs = null === $subject ? array() : array('toto' => 'MesCouilles', 'flipiti' => 'Flop',)/*$subject->getAvailablePositions()*/;

            $form->add('sousMotif', ChoiceType::class, array(
                'label' => 'form.secondReason.label',
                'expanded' => false,
                'multiple' => false,
                'choices'  => $sousMotifs,
            ));
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                // Requête pour charger les sous motifs
                $formModifier($event->getForm(), $data->getSubject());
            }
        );
        $builder->get('subject')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $subject = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $subject);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*Every form needs to know the name of the class that holds the underlying data (e.g. BaseBundle\Entity\Task). Usually, this is just guessed based off of the object passed to the second argument to createForm (i.e. $task). Later, when you begin embedding forms, this will no longer be sufficient. So, while not always necessary, it's generally a good idea to explicitly specify the data_class option by adding the following to your form type class:*/

        $resolver->setDefaults(array(
            'data_class'      => 'BaseBundle\Entity\Contact',
            'translation_domain' => 'validators' # nom des fichiers de traduction
            //'csrf_protection' => true,
            //'csrf_field_name' => '_token',
            //'csrf_token_id'   => 'login_item_01', // A unique key to help generate the secret token (more secure)
        ));
    }
}