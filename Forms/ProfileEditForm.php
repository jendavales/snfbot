<?php

namespace Forms;

use core\Form;
use Forms\ValidationRules\NotNullRule;
use Forms\ValidationRules\RequiredRule;

class ProfileEditForm extends Form
{
    public $id;
    public $name;
    public $quests;
    public $items;
    public $adventures;
    public $quests_xp;
    public $quests_gold;
    public $items_action;
    public $items_speed;
    public $items_sunProtection;
    public $items_greed;
    public $adventures_dinos;

    public function inputsPrefix(): string
    {
        return 'profile_';
    }

    public function loadData(array $data): void
    {
        parent::loadData($data);

//        convert checkboxes
        $this->quests = $this->quests === 'on' ? true : false;
        $this->items = $this->items === 'on' ? true : false;
        $this->adventures = $this->adventures === 'on' ? true : false;
        $this->adventures_dinos = $this->adventures_dinos === 'on' ? true : false;
    }

    public function rules(): array
    {
        return [
            new RequiredRule('name'),
            new NotNullRule('quests'),
            new NotNullRule('quests_gold'),
            new NotNullRule('quests_xp'),
            new NotNullRule('items'),
            new NotNullRule('items_action'),
            new NotNullRule('items_speed'),
            new NotNullRule('items_greed'),
            new NotNullRule('items_sunProtection'),
            new NotNullRule('adventures'),
            new NotNullRule('adventures_dinos'),
        ];
    }
}