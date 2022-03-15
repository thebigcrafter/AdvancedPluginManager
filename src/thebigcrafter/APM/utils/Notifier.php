<?php

declare(strict_types=1);

namespace thebigcrafter\APM\utils;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\APM;

class Notifier
{
	/**
	 * Send a red message to a player
	 */
	public static function error(Player $player, string $message): void
	{
		$player->sendMessage(TextFormat::colorize(APM::$PREFIX . TextFormat::DARK_RED . $message));
	}

	/**
	 * Send a green message to a player
	 */
	public static function success(Player $player, string $message): void
	{
		$player->sendMessage(TextFormat::colorize(APM::$PREFIX . TextFormat::GREEN . $message));
	}

	/**
	 * Send a yellow message to a player
	 */
	public static function warn(Player $player, string $message): void
	{
		$player->sendMessage(TextFormat::colorize(APM::$PREFIX . TextFormat::YELLOW . $message));
	}
}
