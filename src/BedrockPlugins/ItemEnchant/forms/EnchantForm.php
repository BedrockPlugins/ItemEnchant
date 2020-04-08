<?php

namespace BedrockPlugins\ItemEnchant\forms;

use BedrockPlugins\ItemEnchant\ItemEnchant;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class EnchantForm extends CustomForm {

    public function __construct() {
        $callable = function (Player $player, $data) {
            if ($data === null) return;
            $item = $player->getInventory()->getItemInHand();
            if ($item->getId() == Item::AIR) {
                $player->sendMessage(ItemEnchant::$prefix . "You have to hold an item in your hand");
                return;
            }
            if (ItemEnchant::mustBeValid()) {
                if (!ItemEnchant::isValid($item)) {
                    $player->sendMessage(ItemEnchant::$prefix . "This item can not be enchanted");
                    return;
                }
            }
            $enchantmentid = ItemEnchant::$ids[$data[0]];
            $level = $data[1];
            $enchantment = new EnchantmentInstance(Enchantment::getEnchantment($enchantmentid), $level);
            $item->addEnchantment($enchantment);
            $player->getInventory()->setItemInHand($item);
            $player->sendMessage(ItemEnchant::$prefix . "Your item has been enchanted");
        };
        parent::__construct($callable);
        $this->setTitle("ItemEnchant");
        $enchants = [];
        for ($x = 0; $x <= count(ItemEnchant::$ids)-1; $x++) {
            $enchants[] = Enchantment::getEnchantment(ItemEnchant::$ids[$x])->getName();
        }
        $this->addDropdown("Enchantment", $enchants);
        $this->addSlider("Level", 1, ItemEnchant::$max);
    }

}