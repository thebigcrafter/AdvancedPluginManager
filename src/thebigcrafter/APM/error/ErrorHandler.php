<?php

namespace thebigcrafter\APM\error;

use pocketmine\player\Player;
use pocketmine\utils\MainLogger;
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
        switch ($errorCode) {
            case self::$INVALID_URL:
                return "Invalid URL";
                break;
            case self::$PLUGIN_NOT_FOUND:
                return "Plugin not found";
                break;
            case self::$URL_NOT_FOUND:
                return "URL not found";
                break;
            case self::$IS_NOT_A_APM_REPO:
                return "Is not a APM repository";
                break;
            default:
                return "Unknown error";
        }
    }

    /**
     * Sen an error message to player
     *
     * @param Player $player
     * @param int $errorCode
     *
     * @return void
     */
    public static function sendErrorToPlayer(Player $player, int $errorCode): void
    {
        Notifier::error($player, self::getErrorMessage($errorCode));
    }

    /**
     * Send an error message to console
     *
     * @param int $errorCode
     *
     * @return void
     */
    public static function sendErrorToConsole(int $errorCode): void
    {
        APM::getInstance()->getLogger()->error(APM::$PREFIX . TextFormat::DARK_RED . self::getErrorMessage($errorCode));
    }
}
