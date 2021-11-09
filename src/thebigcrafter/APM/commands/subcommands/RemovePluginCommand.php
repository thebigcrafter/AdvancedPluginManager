<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Remover;

class RemovePluginCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setDescription("Removes a plugin");

        $this->registerArgument(0, new RawStringArgument("plugin name"), "The plugin to remove", false);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getRemoveForm());
        } else {
            if (Remover::removePlugin((string) $args["plugin name"])) {
                $sender->sendMessage("§aPlugin removed successfully!");
            } else {
                $sender->sendMessage("§cPlugin not found!");
            }
        }
    }
}
