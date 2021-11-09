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

class InstallPluginCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setDescription("Install a plugin");

        $this->registerArgument(0, new RawStringArgument("plugin name"), "The plugin to install", false);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getInstallForm());
        } else {
            if (Installer::install((string) $args["plugin name"])) {
                $sender->sendMessage(APM::$PREFIX . "§aPlugin installed successfully");
            } else {
                $sender->sendMessage(APM::$PREFIX . "§4Plugin not found!");
            }
        }
    }
}
