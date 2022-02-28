<?php

namespace models\Bot\Item;

class ItemMoves
{
    const EQUIP_MOVE_TYPE = 'equip';
    const DELETE_MOVE_TYPE = 'delete';
    const LOCATION_EQUIP = 'equip';
    const LOCATION_BACKPACK = 'backpack';
    const SLOTS = [
        Item::ITEM_TYPE_HEAD => 4,
        Item::ITEM_TYPE_HAND => 2,
        Item::ITEM_TYPE_RIGHT_SHOE => 0,
        Item::ITEM_TYPE_LEFT_SHOE => 1
    ];
    public $moves;

    public function __construct()
    {
        $this->moves[self::EQUIP_MOVE_TYPE] = [];
        $this->moves[self::DELETE_MOVE_TYPE] = [];
    }

    public function addDeleteMove(DeleteMove $move)
    {
        $this->moves[self::DELETE_MOVE_TYPE][] = $move;
    }

    public function addEquipMove(EquipMove $move)
    {
        $this->moves[self::EQUIP_MOVE_TYPE][] = $move;
    }

    public function getDeleteMoves(): array
    {
        return $this->moves[self::DELETE_MOVE_TYPE];
    }

    public function getEquipMoves(): array
    {
        return $this->moves[self::EQUIP_MOVE_TYPE];
    }
}
