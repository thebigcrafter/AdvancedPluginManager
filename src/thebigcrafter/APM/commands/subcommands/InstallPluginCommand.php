<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Installer;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;

class InstallPluginCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("plugin name"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getInstallPluginForm());
        } else {
            if (Installer::install((string) $args["plugin name"])) {
                $sender->sendMessage(APM::$PREFIX . "§aPlugin installed successfully");
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        }
    }
}
