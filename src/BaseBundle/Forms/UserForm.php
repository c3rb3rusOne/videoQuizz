<?php

// src/BaseBundle/Form/Contact/UserForm.php
namespace BaseBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('required' => true, 'label'  => 'form.username.label'))
            ->add('mail', EmailType::class, array('required' => true, 'label'  => 'form.mail.label'))            
            ->add('password', PasswordType::class, array('required' => true, 'label'  => 'form.password.label'))
            ->add('isActive', CheckboxType::class, array('required' => false, 'data' => true, 'label'  => 'form.isActive.label'))
            ->add('roles', ChoiceType::class, array(
                    'required' => false,
                    'choices' => array(
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ),
                /*'choice_attr' => function($key, $val, $index) {                  
                    if ($key == "ROLE_ADMIN")
                        $hidden = true; //$disabled = true;
                    else
                        $hidden = false; //$disabled = false;

                    //return $disabled ? ['disabled' => 'disabled'] : [];
                    return $hidden ? ['hidden' => 'hidden'] : [];
                },*/
                'label'  => 'form.roles.label',
                //false impossible à cause de l'intégration des outils symfony de login, pour cela:
                //- Change the entity fields: roles -> role, type string - getRole() & setRole()
				//- public function getRoles() { return array($this->role); }
                'multiple' => true,
                'expanded' => true,
                'data' => array('ROLE_USER')
            ))
            ->add('submit', SubmitType::class, array('label'  => 'form.submit.label'));

            //$builder->get('roles')->resetViewTransformers();

            // Listeners (ici pour ajouter dynamiquement la case superUtilisateur quand la case admin est cochée) 
            //http://symfony.com/doc/current/cookbook/form/dynamic_form_modification.html

            /*$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                //FormEvents::PRE_SUBMIT (anciennement PRE_BIND) -> se produit juste après lec clic sur submit, avant traitement de la requête
                //FormEvents::PRE_SET_DATA -> se produit juste avant le chargement des données initiales ds le formulaire

                //->add('value1', 'text', array('required' => true,))
                //$parentChoice = $event->getData();
                //$subChoices = $this->getValidChoicesFor($parentChoice);

                // Ne fais pas l'affaire car le champ roles est réafficher lors de l'affichage des erreurs du formulaire
                $event->getForm()->add('roles', ChoiceType::class, array(
                                        'choices' => array(
                                        'ROLE_USER' => 'ROLE_USER',
                                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                                        'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                ),
                'label'  => 'form.roles.label',
                'multiple' => true,
                'expanded' => true,
                'data' => array('ROLE_USER')
                ));
            });*/

                /*
                // ... adding the name field if needed
                //$product = $event->getData(); // get form's data (object) ?
                $form = $event->getForm();
                //$user = $event->getData(); // entity user -> null ds le cas d'une insertion
                //$isActive = $data->getIsActive();
                //var_dump($form->get('roles'));

                //var_dump($form->get('roles'));exit;

                $form->remove('roles');

                $form->add('roles', ChoiceType::class, array(
                    'choices' => array(
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
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

                // check if the Product object is "new"
                // If no data is passed to the form, the data is "null".
                // This should be considered a new "Product"
                //if (!$product || null === $product->getId()) {
                //$form->add('ROLE_SUPER_ADMIN', TextType::class);
                
            });*/

            //Method 2: par modification du champ
            //$form->get('roles')->setData($document->name);

            //$builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit')); // Version avec fonction déportée

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*Every form needs to know the name of the class that holds the underlying data (e.g. BaseBundle\Entity\Task). Usually, this is just guessed based off of the object passed to the second argument to createForm (i.e. $task). Later, when you begin embedding forms, this will no longer be sufficient. So, while not always necessary, it's generally a good idea to explicitly specify the data_class option by adding the following to your form type class:*/

        $resolver->setDefaults(array(
            'data_class'      => 'BaseBundle\Entity\User',
            'translation_domain' => 'validators' # nom des fichiers de traduction
            //'csrf_protection' => true,
            //'csrf_field_name' => '_token',
            //'csrf_token_id'   => 'login_item_01', // A unique key to help generate the secret token (more secure)
        ));
    }
}