<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

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

		}
	}
}