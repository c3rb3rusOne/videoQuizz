<?php

// src/BaseBundle/ContactSubjectChoiceLoader.php

namespace BaseBundle;

use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ContactSubjectChoiceLoader implements ChoiceLoaderInterface //
{
    // Currently selected choices
    protected $selected = array();
    
    public function __construct($builder)
    {
        if (is_object($builder) && ($builder instanceof FormBuilderInterface))
        {
            // Let the form builder notify us about initial/submitted choices
            $builder->addEventListener(FormEvents::POST_SET_DATA, [ $this, 'onFormPostSetData' ]);
            $builder->addEventListener(FormEvents::POST_SUBMIT, [ $this, 'onFormPostSetData' ]);
        }
    }
    
    /**
     * Enregistrer les possibilités de choix ajoutés initialement
     */
    public function onFormPostSetData(FormEvent $event)
    {
        $this->selected = array();
        
        $InitialFormData = $event->getData();
        
        if (! is_object($InitialFormData))
            return;
                
        $this->selected = $InitialFormData->tags;
    }

    /**
     * Choices to be displayed in the SELECT element at the form display
     * It's okay to not return all available choices, but the selected/submitted choices (model values) must be included.
     * Required by ChoiceLoaderInterface.
     */
    public function loadChoiceList($value = null)
    {
        // Get first n choices
        $InitialChoices = ['Maybe' => 'm', 'Yes' => 'y', 'No' => 'n'];

        // Vérifie que les choices à ajouter ne sont pas déjà présents.
        /*$missing_choices = array_flip($this->selected);
        foreach ($choices as $label => $id)
        {
            if (isset($missing_choices[ $id ]))
                unset($missing_choices[ $id ]);
        }
        
        // Ajoute les choices manquants.
        foreach (array_keys($missing_choices) as $id)
        {
            $label = $this->getChoiceLabel($id);
            
            if (strlen($label) === 0)
                continue;

            $choices[ $label ] = $id;
        }*/
        
        return new ArrayChoiceList($InitialChoices);
    }

    /**
     * Validate submitted choices, and turn them from strings (HTML option values) into other datatypes if needed
     * (not needed here since our choices are strings).
     * We're also using this place for creating new choices from new values typed into the autocomplete field.
     * Required by ChoiceLoaderInterface.
     * Appelée au moment de la validation du choiceType.
     * @param array - $choices An array of choices. Non-existing choices in this array are ignored.
     * @param null|callable - $value The callable generating the choice values. (optional)
     * @return string[] An array of choice values
     */
    public function loadChoicesForValues(array $values, $value = null)
    {
        $result = array();
        
        //var_dump($values);exit; // -> array(1) { [0]=> string(1) "n" }
        foreach ($values as $id)
        {
            $key = array_search($id, $authorizedValues, true); //Ressort la clé si elle se trouve ds le tableau des valeurs possibles

            if ($key !== false)
                $result[ ] = $key;
        }

        return $result;
    }

    /**
     * Turn choices from other datatypes into strings (HTML option values) if needed - we can simply return the choices as they're strings already.
     * Required by ChoiceLoaderInterface.
     * Appelée quand ? Pk ?
     */
    public function loadValuesForChoices(array $choices, $value = null)
    {
        $result = array();
        
        foreach ($choices as $id)
        {
            if ($this->choiceExists($id))
                $result[ ] = $id;
        }
        /*
        foreach ($choices as $label)
        {
            if (isset($this->choices[ $label ]))
                $result[ ] = $this->choices[ $label ];
        }
        */

        return $result;
    }   
    
    
    /**
     * Return the key of the value if this values is authorized
     */
    protected function choiceExists($id)
    {
        $authorizedValues = ['Maybe' => 'm', 'Yes' => 'y', 'No' => 'n'];

        return (array_search($id, $authorizedValues, true)); //Ressort la clé si elle se trouve ds le tableau des valeurs possibles
    }
}