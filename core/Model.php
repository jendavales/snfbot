<?php

namespace core;

use core\ValidationRules\Rule;

abstract class Model
{
    public function __construct(array $variables = [])
    {
        $this->loadPropertiesFromArray($variables);
    }

    public function loadPropertiesFromArray(array $variables = [])
    {
        foreach ($variables as $key => $variable) {
            if (property_exists($this, $key)) {
                $this->{$key} = $variable;
            }
        }
    }
}
