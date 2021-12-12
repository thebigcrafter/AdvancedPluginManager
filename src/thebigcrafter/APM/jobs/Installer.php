<?php

declare(strict_types=1);

namespace thebigcrafter\APM\jobs;

use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;

class Installer
{
    /**
     * Install the plugin. Returns true if plugin is found, false otherwise.
     *
     * @param string $pluginName
     *
     * @return bool
     */
    public static function install(string $pluginName): bool
    {
        $plugins = [];
        $pluginsVersion = [];
        $latestVersion = "";
        $pluginURL = "";
        $hash = [];
        $installed = false;


        foreach (APM::$reposPluginsCache as $plugin) {
            if ($plugin["name"] == $pluginName) {
                $plugins[] = $plugin;
                $pluginsVersion[] = $plugin["version"];
            }
        }

        foreach ($pluginsVersion as $version) {
            if (version_compare($version, $latestVersion, ">") == 1) {
                $latestVersion = $version;
            }
        }

        foreach (APM::$reposPluginsCache as $plugin) {
            if ($plugin["version"] == $latestVersion && $plugin["name"] == $pluginName) {
                $pluginURL = $plugin["download_url"];
                $hash = ["md5" => $plugin["md5"], "sha1" => $plugin["sha1"], "sha256" => $plugin["sha256"], "sha512" => $plugin["sha512"]];
            }
        }
        if (!empty($plugins) && self::downloadPlugin($pluginURL, APM::getInstance()->getServer()->getDataPath() . "plugins/", $hash)) {
            $installed = true;
        }

        return $installed;
    }

    /**
     * Download the plugin. Returns true if plugin is downloaded, false if the URL is invalid
     *
     * @param string $fileURL
     * @param string $path
     * @param array<string> $hash
     *
     * @return bool
     */
    public static function downloadPlugin(string $fileURL, string $path, array $hash): bool
    {
        $file = Internet::getURL($fileURL)->getBody();
        $fileName = basename($fileURL);
        $filePath = $path . $fileName;

        if (file_put_contents($filePath, $file)) {
            if (md5_file($filePath) === $hash["md5"] && sha1_file($filePath) === $hash["sha1"] && hash_file("sha256", $filePath) === $hash["sha256"] && hash_file("sha512", $filePath) === $hash["sha512"]) {
                return true;
            } else {
                unlink($filePath);
                return false;
            }
        } else {
            return false;
        }
    }
}
