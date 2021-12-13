<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Installer;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;

class InstallPluginCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("plugin name"));
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
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getInstallPluginForm()); // @phpstan-ignore-line
        } else {
            if (Installer::install((string) $args["plugin name"])) {
                $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("install.plugin.success"));
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        }
    }
}
