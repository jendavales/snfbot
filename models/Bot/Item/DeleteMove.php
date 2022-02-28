<?php

namespace models\Bot\Item;

class DeleteMove
{
    public $fromLocation;
    public $fromSlot;

    public function __construct(string $fromLocation, int $fromSlot)
    {
        $this->fromLocation = $fromLocation;
        $this->fromSlot = $fromSlot;
    }
}
