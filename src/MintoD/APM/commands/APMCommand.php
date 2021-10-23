<?php

declare(strict_types=1);

namespace MintoD\APM\commands;

use CortexPE\Commando\BaseCommand;
use jojoe77777\FormAPI\SimpleForm;
use MintoD\APM\commands\subcommands\AddRepoCommand;
use MintoD\APM\commands\subcommands\HelpCommand;
use MintoD\APM\commands\subcommands\ListRepoCommand;
use MintoD\APM\forms\MenuForm;
use MintoD\APM\utils\Notifier;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class APMCommand extends BaseCommand {
    protected function prepare(): void
    {
        $this->registerSubCommand(new HelpCommand($this->getPlugin(), "help", "View commands list"));
        $this->registerSubCommand(new AddRepoCommand($this->getPlugin(), "add-repository", "Add repository"));
        $this->registerSubCommand(new ListRepoCommand($this->getPlugin(), "list-repositories", "View repositories list"));
        $this->setPermission("advancedpluginmanager.cmd");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if($sender instanceof Player) {
            $sender->sendForm(MenuForm::getMenuForm());
        } else {
            $sender->sendMessage(Notifier::error("Please use this command in-game"));
        }

    }
}