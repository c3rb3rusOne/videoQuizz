<?php

// src/BaseBundle/Entity/Contact.php
namespace BaseBundle\Entity;

class Contact
{
    protected $id;
    protected $name;
    protected $first_name;
    protected $mail;
    protected $subject;
    protected $sousMotif;
    protected $request;
    
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getSubject()
    {
        return $this->subject;
    }
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    public function getSousMotif()
    {
        return $this->sousMotif;
    }
    public function setSousMotif($sousMotif)
    {
        $this->sousMotif = $sousMotif;
    }

    public function getRequest()
    {
        return $this->request;
    }
    public function setRequest($request)
    {
        $this->request = $request;
    }
}