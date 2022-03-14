<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use thebigcrafter\APM\APM;

class ListPluginCommand extends BaseSubCommand
{
	/**
	 * @param array<string> $args
	 */
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		foreach (APM::$reposPluginsCache as $plugin) {
			$sender->sendMessage($plugin["name"]);
		}
	}

	protected function prepare(): void
	{
	}
}
