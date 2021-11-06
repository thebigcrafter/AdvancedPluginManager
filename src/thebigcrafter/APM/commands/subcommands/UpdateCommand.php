<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\APM;

class UpdateCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setDescription("Update repositories");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $sender->sendMessage(APM::$PREFIX . TextFormat::YELLOW . "Updating...");
        APM::getInstance()->cacheRepo();
        $sender->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Updated!");
    }
}
