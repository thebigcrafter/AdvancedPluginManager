<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\forms\RemoveRepoForm;
use thebigcrafter\APM\tasks\Remover;

class RemoveRepoCommand extends BaseSubCommand
{
	/**
	 * @param array<string> $args
	 *
	 * @throws JsonException
	 */
	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		if ($sender instanceof Player) {
			$sender->sendForm(RemoveRepoForm::get());
		} else {
			if (!isset($args["url"])) {
				ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
			}
			if (Remover::removeRepo((string) $args["url"])) {
				$sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("remove.repo.success"));
			} else {
				ErrorHandler::sendErrorToConsole(ErrorHandler::$URL_NOT_FOUND);
			}
		}
	}

	/**
	 * @throws ArgumentOrderException
	 */
	protected function prepare(): void
	{
		$this->registerArgument(0, new RawStringArgument("url", false));
	}
}
