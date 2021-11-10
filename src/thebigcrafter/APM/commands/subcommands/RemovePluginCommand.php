<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Remover;

class RemovePluginCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("plugin name"), "The plugin to remove", false);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getRemovePluginForm());
        } else {
            if (Remover::removePlugin((string) $args["plugin name"])) {
                $sender->sendMessage("§aPlugin removed successfully!");
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        }
    }
}
