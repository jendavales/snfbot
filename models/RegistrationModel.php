<?php

namespace Models;

use core\Model;
use core\ValidationRules\RequiredRule;
use core\ValidationRules\SameAsRule;

class RegistrationModel extends Model
{
    public $email;
    public $password;
    public $passwordConfirm;

    public function rules(): array
    {
        return [
            new RequiredRule('email', ),
            new RequiredRule('password'),
            new RequiredRule('passwordConfirm'),
            new SameAsRule('passwordConfirm', 'password'),
        ];
    }
}