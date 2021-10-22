<?php

declare(strict_types=1);

namespace MintoD\APM\utils;

use MintoD\libMCUnicodeChars\libMCUnicodeChars;
use pocketmine\utils\TextFormat;

class Notifier
{

    /**
     * @param string $str
     * @return string
     */
    public static function info(string $str): string
    {
        return libMCUnicodeChars::replace(TextFormat::DARK_GREEN . $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function warn(string $str): string
    {
        return libMCUnicodeChars::replace(TextFormat::YELLOW . $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function error(string $str): string
    {
        return libMCUnicodeChars::replace(TextFormat::DARK_RED . $str);
    }
}
