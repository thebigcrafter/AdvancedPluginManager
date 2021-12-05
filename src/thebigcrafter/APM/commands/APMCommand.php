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
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\commands\subcommands\RemovePluginCommand;

class APMCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $subCommands = [
            new AddRepoCommand("add-repo", APM::getLanguage()->translateString("add.repo.command.description")),
            new RemoveRepoCommand("remove-repo", APM::getLanguage()->translateString("remove.repo.command.description")),
            new ListRepoCommand("list-repo", APM::getLanguage()->translateString("list.repo.command.description")),
            new UpdateCommand("update", APM::getLanguage()->translateString("update.command.description")),
            new InstallPluginCommand("install", APM::getLanguage()->translateString("install.plugin.form.title")),
            new RemovePluginCommand("remove", APM::getLanguage()->translateString("remove.command.description"))
        ];
        $this->setDescription(APM::getLanguage()->translateString("apm.command.description"));
        $this->setPermission("apm.cmd");

        foreach ($subCommands as $subCommand) {
            $this->registerSubCommand($subCommand);
        }
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<mixed> $args
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
}
