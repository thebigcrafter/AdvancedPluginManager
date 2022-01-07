<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\ListRepoForm;

class ListRepoCommand extends BaseSubCommand
{
	/**
	 * @param array<string> $args
	 */
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		$repositoriesList = "";
		if ($sender instanceof Player) {
			$sender->sendForm(ListRepoForm::get());
		} else {
			foreach (APM::getInstance()->repos->get("repositories") as $repo) {
				$repositoriesList = $repositoriesList . $repo . "\n";
			}
		}
		$sender->sendMessage($repositoriesList);
	}

	protected function prepare(): void
	{
	}
}
