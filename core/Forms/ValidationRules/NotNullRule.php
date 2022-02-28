<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

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
