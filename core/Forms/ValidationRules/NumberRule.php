<?php

namespace core\Forms\ValidationRules;

use core\Forms\Form;

class NumberRule extends Rule
{
    public $max;
    public $min;

    public function __construct(string $attribute, ?int $max = null, ?int $min = null, ?string $customMessage = null)
    {
        $this->max = $max;
        $this->min = $min;
        parent::__construct($attribute, $customMessage);
    }

    public function isValid(Form $form): bool
    {
        $value = $form->{$this->attribute};
        if (!is_numeric($value)) {
            return false;
        }

        if (!is_null($this->max) && $value > $this->max) {
            return false;
        }

        if (!is_null($this->min) && $value < $this->min) {
            return false;
        }

        return true;
    }

    public function getDefaultErrorMessage(): string
    {
        $msg = 'Toto pole musí být číslo';

        if (!is_null($this->max)) {
            $msg .= ' menší než ' . $this->max;
        }

        if (!is_null($this->min)) {
            $msg .= (!is_null($this->max) ? ' a ' : '') . ' větší než ' . $this->min;
        }

        return $msg . '.';
    }
}
