<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

class LengthRule extends Rule
{
    public $maxLength;
    public $minLength;

    public function __construct(string $attribute, ?int $maxLength = null, ?int $minLength = null, ?string $customMessage = null)
    {
        $this->maxLength = $maxLength;
        $this->minLength = $minLength;
        parent::__construct($attribute, $customMessage);
    }

    public function isValid(Form $form): bool
    {
        $length = strlen($form->{$this->attribute});

        if (!is_null($this->minLength) && $this->minLength > $length) {
            return false;
        }

        if (!is_null($this->maxLength) && $this->maxLength < $length) {
            return false;
        }

        return true;
    }

    public function getDefaultErrorMessage(): string
    {
        return "Délka $this->attribute musí být mezi $this->minLength a $this->maxLength znaky.";
    }
}