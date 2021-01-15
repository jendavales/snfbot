<?php

namespace core\ValidationRules;

class RequiredRule extends Rule
{
    public function isValid(\core\Model $model): bool
    {
        return !empty($model->{$this->attribute});
    }

    public function getDefaultErrorMessage(): string
    {
        return "Toto pole je povinné";
    }
}
