<?php

namespace Forms\ValidationRules;

use core\Form;
use core\Rule;

class RequiredRule extends Rule
{
    public function isValid(Form $form): bool
    {
        return !empty($form->{$this->attribute});
    }

    public function getDefaultErrorMessage(): string
    {
        return "Toto pole je povinné";
    }
}
