<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands;

use CortexPE\Commando\BaseCommand;
use thebigcrafter\APM\commands\subcommands\AddRepoCommand;
use thebigcrafter\APM\commands\subcommands\ListRepoCommand;
use thebigcrafter\APM\commands\subcommands\RemoveRepoCommand;
use thebigcrafter\APM\commands\subcommands\UpdateCommand;
use thebigcrafter\APM\commands\subcommands\InstallPluginCommand;
use thebigcrafter\APM\forms\MenuForm;
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
        $this->registerSubCommand(new InstallPluginCommand($this->getPlugin(), "install", "Install plugin"));
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