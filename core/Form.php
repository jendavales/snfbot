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

    public function inputsPrefix(): string
    {
        return '';
    }

    public function loadData(array $data): void
    {
        $inputsPrefix = $this->inputsPrefix();
        foreach ($data as $key => $value) {
            $keyNoPrefix = substr($key, strlen($inputsPrefix));
            if (property_exists($this, $keyNoPrefix)) {
                $this->{$keyNoPrefix} = $value;
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
