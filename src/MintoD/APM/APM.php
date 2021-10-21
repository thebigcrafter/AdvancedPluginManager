<?php

declare(strict_types=1);

namespace MintoD\APM;

use MintoD\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;

class APM extends PluginBase {
    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced plugin manager commands"));
    }
}