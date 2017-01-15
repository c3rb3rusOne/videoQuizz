<?php
// src/BaseBundle/Event/UserCreatedListener.php
namespace BaseBundle\Event;

class UserCreatedListener
{

    protected $mailerMaison;

    public function __construct($mailerMaison)
    {
        $this->mailerMaison = $mailerMaison;
    }

    public function process($event)
    {
        print($event->getUserEmail());

        $this->mailerMaison->sentValidationEmail($event->getUserEmail(), $event->getUrlValidation());
    }
}