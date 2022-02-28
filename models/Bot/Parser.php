<?php

namespace models\Bot;

use models\Bot\Item\Item;
use models\Bot\Item\Inventory;
use models\Bot\Quest\Quest;
use models\Bot\Quest\Quests;

class Parser
{
    public static function getCharacterImages(\DOMXPath $path): array
    {
        $characterImages = [];
        $imagesContainer = $path->query('//div[@class="character"]')->item(0);
        foreach ($imagesContainer->childNodes as $imageNode) {
            $characterImages[] = str_replace('assets/img/', 'https://snf.piorecky.cz/assets/img/', $imageNode->getAttribute('src'));
        }
        return $characterImages;
    }

    public static function getLevelProgress(\DOMXPath $path): string
    {
        return $path->query('//div[@class="level_progress_value"]')->item(0)->textContent;
    }

    public static function getLevel(\DOMXPath $path): int
    {
        return $path->query('//div[@id="value_level"]')->item(0)->textContent;
    }

    public static function getQuests(\DOMXPath $path): ?Quests
    {
        $xps = $path->query('//div[@class="experience_value"]');

        if ($xps->length === 0) {
            return null;
        }

        $golds = $path->query('//div[@class="currency_value"]');
        $energies = $path->query('//div[contains(@class, "energy_cost")]');

        $quests = [];
        for ($i = 0; $i < 3; $i++) {
            $quests[] = new Quest($i, $xps->item($i)->textContent, $golds->item($i)->textContent, $energies->item($i)->textContent);
        }

        return new Quests($quests);
    }

    public static function getInventory(string $html): Inventory
    {
        $arrayStart = strpos($html, 'items = ') + strlen('items = ');
        $arrayEnd = strpos($html, '];', $arrayStart) + strlen('];');
        $itemsJson = json_decode(mb_substr($html, $arrayStart, $arrayEnd - $arrayStart - 1), true);
        $items = [];
        foreach ($itemsJson as $itemRaw) {
            $effects = self::parseItemEffects($itemRaw['effects']);
            $item = new Item($itemRaw['type'], $effects[Item::SUN_PROTECTION_NAME], $effects[Item::SPEED_NAME], $effects[Item::GREED_NAME], $itemRaw['slot'], $itemRaw['location']);
            $items[] = $item;
        }

        return new Inventory($items);
    }

    public static function containsAdventuresToken(\DOMXPath $path): bool
    {
        return $path->query("//div[@class='fight_button']//img")->length !== 0;
    }

    private static function parseItemEffects(array $effectsArray): array
    {
        $effects = [
            Item::GREED_NAME => 0,
            Item::SUN_PROTECTION_NAME => 0,
            Item::SPEED_NAME => 0
        ];

        foreach ($effectsArray as $effect) {
            $effects[$effect['name']] = $effect['value'];
        }

        return $effects;
    }
}