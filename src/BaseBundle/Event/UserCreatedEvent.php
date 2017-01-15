<?php
// src/BaseBundle/Event/UserCreatedEvent.php
namespace BaseBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class UserCreatedEvent extends Event
{
    protected $userEmail;
    protected $urlValidation;

    public function __construct($userEmail, $urlValidation)
    {
        $this->userEmail = $userEmail;
        $this->urlValidation = $urlValidation;
    }

    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function getUrlValidation()
    {
        return $this->urlValidation;
    }
}