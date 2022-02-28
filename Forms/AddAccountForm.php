<?php

namespace Forms;

use core\Forms\Form;

class AddAccountForm extends Form
{
    public $name;
    public $password;

    public function inputsPrefix(): string
    {
        return 'add_';
    }

    public function rules(): array
    {
        return [];
    }
}
