<?php

declare(strict_types=1);

namespace thebigcrafter\APM\utils;

use pocketmine\utils\Internet;

class Utils
{
    /**
     * Check if the given string is a APM repo URL. NOTE: The URL must end with a slash.
     *
     * @param string $url
     * @return boolean
     */
    public static function isAPMRepo(string $url): bool
    {
        $release = Internet::getURL($url . "Release.json")->getBody();
        $plugins = Internet::getURL($url . "Plugins.json")->getBody();

        if ($plugins === false || $release === false) {
            return false;
        }

        $release = json_decode($release, true);

        if (isset($release["label"]) && isset($release["suite"]) && isset($release["codename"]) && isset($release["description"])) {
            return true;
        } else {
            return false;
        }
    }
}
