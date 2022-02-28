<?php

namespace models\Bot\Item;

class EquipMove
{
    public $fromLocation;
    public $fromSlot;
    public $toLocation;
    public $toSlot;

    public function __construct(string $fromLocation, int $fromSlot, string $toLocation, int $toSlot)
    {
        $this->fromLocation = $fromLocation;
        $this->fromSlot = $fromSlot;
        $this->toLocation = $toLocation;
        $this->toSlot = $toSlot;
    }
}
