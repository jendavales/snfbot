<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

class SameAsRule extends Rule
{
    private $comparedAttribute;

    public function __construct(string $attribute, string $comparedAttribute, string $customMessage = '')
    {
        parent::__construct($attribute, $customMessage);
        $this->comparedAttribute = $comparedAttribute;
    }

    public function isValid(Form $form): bool
    {
        return $form->{$this->attribute} === $form->{$this->comparedAttribute};
    }

    public function getDefaultErrorMessage(): string
    {
        return 'Pole se musí shodovat';
    }
}
