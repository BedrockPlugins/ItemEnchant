<?php

namespace BedrockPlugins\ItemEnchant;

use BedrockPlugins\ItemEnchant\commands\ItemEnchantCommand;
use pocketmine\item\Armor;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class ItemEnchant extends PluginBase {

    public static $prefix = TextFormat::AQUA . "ItemEnchant " . TextFormat::DARK_GRAY . "» " . TextFormat::GRAY;

    private static $valid = false;

    public static $max = 100;

    public static $ids = [
        Enchantment::PROTECTION,
        Enchantment::FIRE_PROTECTION,
        Enchantment::FEATHER_FALLING,
        Enchantment::BLAST_PROTECTION,
        Enchantment::PROJECTILE_PROTECTION,
        Enchantment::THORNS,
        Enchantment::RESPIRATION,
        Enchantment::SHARPNESS,
        Enchantment::KNOCKBACK,
        Enchantment::FIRE_ASPECT,
        Enchantment::EFFICIENCY,
        Enchantment::SILK_TOUCH,
        Enchantment::UNBREAKING,
        Enchantment::POWER,
        Enchantment::PUNCH,
        Enchantment::FLAME,
        Enchantment::INFINITY,
        Enchantment::MENDING,
        Enchantment::VANISHING
    ];

    public function onEnable() {

        $this->saveResource("config.yml", false);

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        if ($config->exists("mustbetool") && is_bool($config->get("mustbetool"))) {
            self::$valid = $config->get("mustbetool");
        }
        if ($config->exists("maxlevel") && is_numeric($config->get("maxlevel"))) {
            self::$max = $config->get("maxlevel");
        }

        $this->getServer()->getCommandMap()->register("itemenchant", new ItemEnchantCommand("itemenchant", "Enchants the item you're holding"));
    }

    public static function mustBeValid() : bool {
        return self::$valid;
    }

    public static function isValid(Item $item) {
        return $item instanceof Tool || $item instanceof Armor;
    }

}