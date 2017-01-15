<?php
// src/BaseBundle/Validator/Constraints/CustomValid.php
namespace BaseBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class CustomValid extends Constraint
{
    public $message = 'form.request.error';
}