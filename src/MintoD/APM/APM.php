<?php

declare(strict_types=1);

namespace MintoD\APM;

use MintoD\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class APM extends PluginBase {

    /**
     * APM's Prefix
     * @var string
     */
    public const PREFIX = "{TOKEN}";

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced plugin manager commands"));
        $this->saveDefaultConfig();
    }
}