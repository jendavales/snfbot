<?php

namespace core\ValidationRules;

class SameAsRule extends Rule
{
    private $comparedAttribute;

    public function __construct(string $attribute, string $comparedAttribute)
    {
        parent::__construct($attribute);
        $this->comparedAttribute = $comparedAttribute;
    }

    public function isValid(\core\Model $model): bool
    {
        return $model->{$this->attribute} === $model->{$this->comparedAttribute};
    }

    public function getDefaultErrorMessage(): string
    {
        return 'Pole se musí shodovat';
    }
}
