<?php

declare(strict_types=1);

namespace thebigcrafter\APM\utils;

use pocketmine\player\Player;
use thebigcrafter\APM\APM;

class Notifier
{
    /**
     * Send a red message to a player
     *
     * @param Player $player
     * @param string $message
     *
     * @return void
     */
    public static function error(Player $player, string $message): void
    {
        $player->sendMessage(APM::$PREFIX . "§4" . $message);
    }

    /**
     * Send a green message to a player
     *
     * @param Player $player
     * @param string $message
     *
     * @return void
     */
    public static function success(Player $player, string $message): void
    {
        $player->sendMessage(APM::$PREFIX . "§a" . $message);
    }

    /**
     * Send a yellow message to a player
     *
     * @param Player $player
     * @param string $message
     *
     * @return void
     */
    public static function warn(Player $player, string $message): void
    {
        $player->sendMessage(APM::$PREFIX . "§e" . $message);
    }
}
