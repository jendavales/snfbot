<?php

namespace core;

use core\ValidationRules\Rule;

abstract class Model
{
    public $errors;

    abstract public function rules(): array;

    public function loadData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function validate(): bool
    {
        $this->errors = [];

        /** @var Rule $rule */
        foreach ($this->rules() as $rule) {
            if (!$rule->isValid($this)) {
                $this->errors[$rule->attribute][] = $rule->getErrorMessage($this);
            }

        }

        return count($this->errors) === 0;
    }
}
