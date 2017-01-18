<?php
// src/BaseBundle/Form/Type/DemandeType.php - The location of this file is not important - the Form\Type directory is just a convention.

/* Template du champs à définir (si besoin sinon celui de TextArea sera utilisé)
{# app/Resources/views/form/fields.html.twig #} -> {% block demande_widget %} XXX {% endblock %} */

namespace BaseBundle\Forms\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

// Pour surdéfinir buildView
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;



class DemandeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data' => 'abcdef',
            'attr' => array('onfocus' => "this.value=''; document.getElementsByTagName('textarea')[0].removeAttribute('onfocus');"),
            'always_empty' => true,
            #'attr' => array('onclick' => "this.value=''; document.anchors['ancDevx'].removeAttribute('onclick');"),
        ));
    }

    // Empêche le réaffichage de la valeur de la demande en cas d'erreur - Copié depuis PasswordType dont la valeur ne se réaffiche pas en cas d'erreur
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['always_empty'] || !$form->isSubmitted()) {
            $view->vars['value'] = '';
        }
    }

    public function getParent()
    {
        return TextareaType::class; // = extending the TextType - ...\vendor\symfony\symfony\src\Symfony\Component\Form\Extension\Core\Type\
    }
}