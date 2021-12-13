<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\commands\subcommands\AddRepoCommand;
use thebigcrafter\APM\commands\subcommands\InstallPluginCommand;
use thebigcrafter\APM\commands\subcommands\ListPluginCommand;
use thebigcrafter\APM\commands\subcommands\ListRepoCommand;
use thebigcrafter\APM\commands\subcommands\RemovePluginCommand;
use thebigcrafter\APM\commands\subcommands\RemoveRepoCommand;
use thebigcrafter\APM\commands\subcommands\UpdateCommand;
use thebigcrafter\APM\forms\MenuForm;

class APMCommand extends BaseCommand
{
    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<string> $args
     *
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(MenuForm::getMenuForm());
        } else {
            $this->sendUsage();
        }
    }

    protected function prepare(): void
    {
        $subCommands = [
            new AddRepoCommand("add-repo", APM::getLanguage()->translateString("add.repo.command.description")),
            new RemoveRepoCommand("remove-repo", APM::getLanguage()->translateString("remove.repo.command.description")),
            new ListRepoCommand("list-repo", APM::getLanguage()->translateString("list.repo.command.description")),
            new UpdateCommand("update", APM::getLanguage()->translateString("update.command.description")),
            new InstallPluginCommand("install", APM::getLanguage()->translateString("install.plugin.form.title")),
            new RemovePluginCommand("remove", APM::getLanguage()->translateString("remove.command.description")),
            new ListPluginCommand("list", APM::getLanguage()->translateString("list.command.description")),
        ];
        $this->setDescription(APM::getLanguage()->translateString("apm.command.description"));
        $this->setPermission("apm.cmd");

        foreach ($subCommands as $subCommand) {
            $this->registerSubCommand($subCommand);
        }
    }
}
