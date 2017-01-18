<?php

namespace BaseBundle\Entity;

class Answer
{
    private $id;
    private $answer;
    private $question;

    public function getId()
    {
        return $this->id;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    public function getQuestion()
    {
        return $this->question;
    }
}
