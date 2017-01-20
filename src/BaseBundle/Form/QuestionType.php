<?php

namespace BaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')->add('media')->add('theme')

        /*
         * Imbrication d'un ou plusieurs formulaires Answer histoire d'ajouter la question ET la ou
         * les réponses sur une même page.
         *
         * Rappel :
         ** - 1er argument : nom du champ de l'entity Question, « answers »
         ** - 2e argument : type du champ, ici « collection » qui est une liste de quelque chose
         ** - 3e argument : tableau d'options du champ
        */

        // Symfony 3
        ->add("answers", CollectionType::class, array(
                'entry_type' => AnswerType::class,
                'allow_add' => true,
                'allow_delete' => true
            )
        );

        /* Symfony 2
        ->add('answers', 'collection', array(
            'type'         => new AnswerType(),
            'allow_add'    => true,
            'allow_delete' => true
           ));*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaseBundle\Entity\Question'
        ));
    }

    public function getBlockPrefix()
    {
        return 'basebundle_question';
    }


}
