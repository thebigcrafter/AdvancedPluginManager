<?php

declare(strict_types=1);

namespace MintoD\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use MintoD\APM\APM;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class UpdateCommand extends BaseSubCommand {
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