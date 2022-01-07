<?php

declare(strict_types=1);

namespace thebigcrafter\APM\error;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\utils\Notifier;

class ErrorHandler
{
	public static int $INVALID_URL = 0;
	public static int $PLUGIN_NOT_FOUND = 1;
	public static int $URL_NOT_FOUND = 2;
	public static int $IS_NOT_A_APM_REPO = 3;

	private static function getErrorMessage(int $errorCode): string
	{
		return match ($errorCode) {
			self::$INVALID_URL => "Invalid URL",
			self::$PLUGIN_NOT_FOUND => "Plugin not found",
			self::$URL_NOT_FOUND => "URL not found",
			self::$IS_NOT_A_APM_REPO => "Is not a APM repository",
			default => "Unknown error",
		};
	}

	/**
	 * Sen an error message to player
	 */
	public static function sendErrorToPlayer(Player $player, int $errorCode): void
	{
		Notifier::error($player, self::getErrorMessage($errorCode));
	}

	/**
	 * Send an error message to console
	 */
	public static function sendErrorToConsole(int $errorCode): void
	{
		APM::getInstance()->getLogger()->error(APM::$PREFIX . TextFormat::DARK_RED . self::getErrorMessage($errorCode));
	}
}
