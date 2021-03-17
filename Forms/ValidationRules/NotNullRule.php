<?php


namespace Forms\ValidationRules;


use core\Form;
use core\Rule;

class NotNullRule extends Rule
{
    public function isValid(Form $form): bool
    {
        return !is_null($form->{$this->attribute});
    }

    public function getDefaultErrorMessage(): string
    {
        return "Toto pole nesmí být nulové.";
    }
}
