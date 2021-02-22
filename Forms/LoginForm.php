<?php

namespace Forms;

use core\Form;
use Forms\ValidationRules\RequiredRule;

class LoginForm extends Form
{
    public $email;
    public $password;

    public function rules(): array
    {
        return [
            new RequiredRule('email',),
            new RequiredRule('password'),
        ];
    }
}
