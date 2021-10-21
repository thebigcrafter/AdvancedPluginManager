<?php

declare(strict_types=1);

namespace MintoD\APM\commands;

use CortexPE\Commando\BaseCommand;
use MintoD\APM\commands\subcommands\HelpCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class APMCommand extends BaseCommand {
    protected function prepare(): void
    {
        $this->registerSubCommand(new HelpCommand($this->getPlugin(), "help", "View all commands list"));
        //$this->setUsage(TextFormat::YELLOW . "/apm help");
        $this->setPermission("advancedpluginmanager.cmd");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if($sender instanceof Player) {
            $this->sendUsage();
        } else {
            $sender->sendMessage(TextFormat::DARK_RED . "Please use this command in-game");
        }

    }
}