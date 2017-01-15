<?php
// src/BaseBundle/Validator/Constraints/CustomValidValidator.php
namespace BaseBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomValidValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
    	// Checks if $value contains only alphanumeric characters
        if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches))
        {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}