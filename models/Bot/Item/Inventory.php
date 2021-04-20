<?php

namespace models\Bot\Item;

use Models\Profile;

class Inventory
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;

        /** @var Item $item */
        foreach ($items as $item) {
            $this->items[$item->type][] = $item;
        }
    }

    public function getItem(string $type, int $index): Item
    {
        return $this->items[$type][$index];
    }

    public function calculateItemMoves(Profile $profile): ItemMoves
    {
        $moves = new ItemMoves();

        foreach (Item::ITEM_TYPES as $ITEM_TYPE) {
            if (!is_array($this->items[$ITEM_TYPE])) {
                continue;
            }


            $itemsOfTypeCount = count($this->items[$ITEM_TYPE]);
            if ($itemsOfTypeCount < 1) {
                continue;
            }

            $bestItem = $this->getItem($ITEM_TYPE, 0);
            $bestValue = $bestItem->calculateValue($profile);
            for ($i = 1; $i < $itemsOfTypeCount; $i++) {
                $currentItem = $this->getItem($ITEM_TYPE, $i);
                $currentItemValue = $currentItem->calculateValue($profile);
                if ($currentItemValue > $bestValue) {
                    //add delete for current best
                    $moves->addDeleteMove(new DeleteMove($bestItem->location, $bestItem->slot));
                    $bestValue = $currentItemValue;
                    $bestItem = $currentItem;
                } else {
                    $moves->addDeleteMove(new DeleteMove($currentItem->location, $currentItem->slot));
                }
            }
            //equip best item found
            if ($bestItem->location !== ItemMoves::EQUIP_MOVE_TYPE) {
                $moves->addEquipMove(new EquipMove($bestItem->location, $bestItem->slot, ItemMoves::LOCATION_EQUIP, ItemMoves::SLOTS[$ITEM_TYPE]));
            }
        }

        return $moves;
    }
}
