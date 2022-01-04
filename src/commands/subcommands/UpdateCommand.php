<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\tasks\Updater;

class UpdateCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<string> $args
     *
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("start.update.message"));
        Updater::updateRepo();
        $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("end.update.message"));
    }
}
