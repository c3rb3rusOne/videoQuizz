<?php

namespace BaseBundle\Entity;

class Session
{
    private $id;
    private $title;
    private $questions; //?
    private $participants; //?

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

    public function getQuestions()
    {
        return $this->questions;
    }

    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    public function getParticipants()
    {
        return $this->participants;
    }
}
