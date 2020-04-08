<?php

namespace BedrockPlugins\ItemEnchant\commands;

use BedrockPlugins\ItemEnchant\forms\EnchantForm;
use BedrockPlugins\ItemEnchant\ItemEnchant;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class ItemEnchantCommand extends Command {
    
    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []) {
        $this->setPermission("command.itemenchant");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) return;
        if (!$sender->hasPermission("command.itemenchant")) {
            $sender->sendMessage(ItemEnchant::$prefix . "You don't have permissions to use this command");
            return;
        }
        $item = $sender->getInventory()->getItemInHand();
        if ($item->getId() == Item::AIR) {
            $sender->sendMessage(ItemEnchant::$prefix . "You have to hold an item in your hand");
            return;
        }
        if (ItemEnchant::mustBeValid()) {
            if (!ItemEnchant::isValid($item)) {
                $sender->sendMessage(ItemEnchant::$prefix . "This item can not be enchanted");
                return;
            }
        }
        $sender->sendForm(new EnchantForm());
    }

}