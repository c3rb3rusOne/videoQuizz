<?php

// src/BaseBundle/Form/Contact/Login.php
namespace BaseBundle\Forms\Login;

// G:\Dropbox\ESPACE_TRAVAIL\Symfony_3\Cerberus\vendor\symfony\symfony\src\Symfony\Component\Form\Extension\Core\Type
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class loginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('required' => true, 'label' => 'form.username.label'))
            ->add('password', PasswordType::class, array('required' => true, 'label'  => 'form.password.label'))
            ->add('remember_me', CheckboxType::class, array('required' => false, 'data' => true, 'label'  => 'form.remember_me.label')) // 'data' => 'true' -> méthode préconisée par symfony pr cocher par défaut
            #->add('_csrf_token', HiddenType::class, array('required' => false, 'csrf_protection' => true)) // Champ requis pour la protection csrf, déjà ok si le formulaire se trouve encadré par form xxx et form end
            ->add('login', SubmitType::class, array('label'  => 'form.login.label'));
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