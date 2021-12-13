<?php

declare(strict_types=1);

namespace thebigcrafter\APM\utils;

use pocketmine\utils\Internet;

class Utils
{
    /**
     * Check if the given string is an APM repo URL. NOTE: The URL must end with a slash.
     *
     * @param string $url
     * @return boolean
     */
    public static function isAPMRepo(string $url): bool
    {
        $release = Internet::getURL($url . "Release.json")->getCode();
        $plugins = Internet::getURL($url . "Plugins.json")->getCode();

        if ($plugins !== 200 || $release !== 200) {
            return false;
        }

        $release = json_decode(Internet::getURL($url . "Release.json")->getBody(), true);

        if (isset($release["label"]) && isset($release["suite"]) && isset($release["codename"]) && isset($release["description"])) {
            return true;
        } else {
            return false;
        }

        // TODO: Check the Plugins.json is valid.
    }

    /**
     * @param array<string> $versions
     *
     * @return string
     */
    public static function getLatestVersion(array $versions): string
    {
        $latest = "";

        foreach ($versions as $version) {
            if (version_compare($version, $latest) > $latest) {
                $latest = $version;
            }
        }

        return $latest;
    }
}
