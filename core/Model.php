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

    public function toArray(array $attributes = []): array
    {
        $return = [];

        if (count($attributes) === 0) {
            return get_object_vars($this);
        }

        foreach ($attributes as $key) {
            $return[$key] = $this->{$key};
        }

        return $return;
    }
}
