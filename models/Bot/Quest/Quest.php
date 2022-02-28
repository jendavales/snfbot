<?php

namespace models\Bot\Quest;

use Models\Profile;

class Quest
{
    public $id;
    public $xp;
    public $gold;
    public $energy;

    public function __construct($id, $xp, $gold, $energy)
    {
        $this->id = $id;
        $this->xp = $xp;
        $this->gold = $gold;
        $this->energy = $energy;
    }

    public function getValueForProfile(Profile $profile)
    {
        $value = $this->xp * $profile->quests_xp + $this->gold * $profile->quests_gold;

        return $value / $this->energy;
    }

}
