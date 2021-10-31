<?php

declare(strict_types=1);

namespace MintoD\APM\commands;

use CortexPE\Commando\BaseCommand;
use MintoD\APM\commands\subcommands\AddRepoCommand;
use MintoD\APM\commands\subcommands\ListRepoCommand;
use MintoD\APM\commands\subcommands\RemoveRepoCommand;
use MintoD\APM\commands\subcommands\UpdateCommand;
use MintoD\APM\forms\MenuForm;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class APMCommand extends BaseCommand {
    protected function prepare(): void
    {
        $this->setDescription("APM commands");
        $this->setPermission("apm.cmd");

        $this->registerSubCommand(new AddRepoCommand($this->getPlugin(), "add-repo", "Add repository"));
        $this->registerSubCommand(new RemoveRepoCommand($this->getPlugin(), "remove-repo", "Remove repository"));
        $this->registerSubCommand(new ListRepoCommand($this->getPlugin(), "list-repo", "List repositories"));
        $this->registerSubCommand(new UpdateCommand($this->getPlugin(), "update", "Update repositories"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if($sender instanceof Player) {
            $sender->sendForm(MenuForm::getMenuForm());
        } else {
            $this->sendUsage();
        }
    }
}