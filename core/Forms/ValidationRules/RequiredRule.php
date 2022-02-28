<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

class RequiredRule extends Rule
{
    public function isValid(Form $form): bool
    {
        return !empty($form->{$this->attribute});
    }

    public function getDefaultErrorMessage(): string
    {
        return "Toto pole je povinné.";
    }
}
