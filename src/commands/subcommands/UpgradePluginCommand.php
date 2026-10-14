<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\forms\UpgradePluginForm;
use thebigcrafter\APM\tasks\Updater;

class UpgradePluginCommand extends BaseSubCommand {
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
		if($sender instanceof Player) {
			$sender->sendForm(UpgradePluginForm::get());
			return;
		}
		if (!isset($args["plugin name"]) || !Updater::updatePlugin((string) $args["plugin name"])) {
			ErrorHandler::sendErrorToConsole(ErrorHandler::$PLUGIN_NOT_FOUND);
			return;
		}
		$sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("upgrade.plugin.success"));
	}
}
