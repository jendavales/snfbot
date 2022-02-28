<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

abstract class Rule
{
    public $attribute;
    private $customMessage;

    public function __construct(string $attribute, ?string $customMessage = null)
    {
        $this->attribute = $attribute;
        $this->customMessage = $customMessage;
    }

    public abstract function isValid(Form $form): bool;

    public abstract function getDefaultErrorMessage(): string;

    public function getErrorMessage(): string
    {
        return $this->customMessage ?? $this->getDefaultErrorMessage();
    }
}
