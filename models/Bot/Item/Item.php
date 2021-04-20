<?php

namespace models\Bot\Item;

use Models\Profile;

class Item
{
    const SUN_PROTECTION_NAME = 'Sun protection';
    const GREED_NAME = 'Greed';
    const SPEED_NAME = 'Speed';
    const ITEM_TYPE_HEAD = 'head';
    const ITEM_TYPE_HAND = 'hand';
    const ITEM_TYPE_RIGHT_SHOE = 'right_shoe';
    const ITEM_TYPE_LEFT_SHOE = 'left_shoe';
    const ITEM_TYPES = [self::ITEM_TYPE_HEAD, self::ITEM_TYPE_HAND, self::ITEM_TYPE_LEFT_SHOE, self::ITEM_TYPE_RIGHT_SHOE];

    public $type;
    public $sun_resistance;
    public $speed;
    public $greed;
    public $slot;
    public $location;

    public function __construct(string $type, int $sun_resistance, int $speed, int $greed, int $slot, string $location)
    {
        $this->type = $type;
        $this->sun_resistance = $sun_resistance;
        $this->speed = $speed;
        $this->greed = $greed;
        $this->slot = $slot;
        $this->location = $location;
    }

    public function calculateValue(Profile $profile): int
    {
        return $this->speed * $profile->items + $this->greed * $profile->items_greed + $this->sun_resistance * $profile->items_sunProtection;
    }
}
