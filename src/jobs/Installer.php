<?php

declare(strict_types=1);

namespace thebigcrafter\APM\jobs;

use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\utils\Utils;

class Installer
{
    /**
     * Install the plugin. Returns true if plugin is installed, false otherwise.
     *
     * @param string $pluginName
     *
     * @return bool
     */
    public static function install(string $pluginName): bool
    {
        $pluginVers = [];
        $pluginDownloadURL = "";
        $hash = [];

        foreach (APM::$reposPluginsCache as $plugin) {
            if ($plugin["name"] === $pluginName) {
                $pluginVers[] = $plugin["version"];
            }
        }

        $latestVersion = Utils::getLatestVersion($pluginVers);

        foreach (APM::$reposPluginsCache as $plugin) {
            if ($plugin["name"] === $pluginName && $plugin["version"] === $latestVersion) {
                $pluginDownloadURL = $plugin["download_url"];
                $hash = ["md5" => $plugin["md5"], "sha1" => $plugin["sha1"], "sha256" => $plugin["sha256"], "sha512" => $plugin["sha512"]];
            }
        }

        $filePath = APM::getInstance()->getServer()->getDataPath() . "plugins/" . basename($pluginDownloadURL);

        if (is_file($filePath)) {
            return false;
        }

        if (file_put_contents($filePath, Internet::getURL($pluginDownloadURL)->getBody()) == false) {
            return false;
        }

        if ($hash["md5"] === md5_file($filePath) && $hash["sha1"] === sha1_file($filePath) && $hash["sha256"] === hash_file("sha256", $filePath) && $hash["sha512"] === hash_file("sha512", $filePath)) {
            return true;
        } else {
            return false;
        }
    }
}
