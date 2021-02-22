<?php

namespace core;

use core\ValidationRules\Rule;

abstract class Form
{
    public $errors;

    public function __construct()
    {
        $this->errors = [];
    }

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
        /** @var Rule $rule */
        foreach ($this->rules() as $rule) {
            if (!$rule->isValid($this)) {
                $this->errors[$rule->attribute][] = $rule->getErrorMessage($this);
            }

        }

        return count($this->errors) === 0;
    }

    public function toArray(): array
    {
        $return = [];

        foreach ($this as $key => $value) {
            $return[$key] = $value;
        }

        return $return;
    }

    public function addError(string $field, string $value): void
    {
        $this->errors[$field][] = $value;
    }
}
