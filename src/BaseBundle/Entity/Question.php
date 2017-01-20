<?php

namespace BaseBundle\Entity;

class Question
{
    private $id;
    private $title;
    private $media;
    private $theme;
    private $answers;

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

    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    public function getMedia()
    {
        return $this->media;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function __toString()
    {
        return (string) $this->title;
    }

    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    public function getAnswers()
    {
        return $this->answers;
    }
}

