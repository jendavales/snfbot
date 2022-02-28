<?php


namespace models\Bot\Quest;


use Models\Profile;

class Quests
{
    public $quests;

    public function __construct(array $quests)
    {
        $this->quests = $quests;
    }

    public function bestQuest(Profile $profile): Quest
    {
        $bestVal = 0;
        $bestMission = null;

        /** @var Quest $quest */
        foreach ($this->quests as $quest) {
            $val = $quest->getValueForProfile($profile);
            if ($val > $bestVal) {
                $bestVal = $val;
                $bestMission = $quest;
            }
        }

        return $bestMission;
    }

}