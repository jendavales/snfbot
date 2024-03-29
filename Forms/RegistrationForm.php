<?php

namespace Forms;

use core\Forms\Form;
use core\Forms\ValidationRules\LengthRule;
use core\Forms\ValidationRules\RequiredRule;
use core\Forms\ValidationRules\SameAsRule;

class RegistrationForm extends Form
{
    public $email;
    public $password;
    public $passwordConfirm;

    public function rules(): array
    {
        return [
            new RequiredRule('email',),
            new RequiredRule('password'),
            new RequiredRule('passwordConfirm'),
            new SameAsRule('passwordConfirm', 'password', 'Hesla se musí shodovat!'),
            new LengthRule('password', 512, 6, 'Minimální délka hesla je 6 znaků!'),
        ];
    }
}
