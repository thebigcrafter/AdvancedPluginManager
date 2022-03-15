<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\forms\InstallPluginForm;
use thebigcrafter\APM\tasks\Installer;

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
	 * @param array<string> $args
	 */
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		if ($sender instanceof Player) {
			$sender->sendForm(InstallPluginForm::get());
		} else {
			if (Installer::install((string) $args["plugin name"])) {
				$sender->sendMessage(TextFormat::colorize(APM::$PREFIX . APM::getLanguage()->translateString("install.plugin.success")));
			} else {
				ErrorHandler::sendErrorToConsole(ErrorHandler::$PLUGIN_NOT_FOUND);
			}
		}
	}
}
