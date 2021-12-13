<?php

namespace thebigcrafter\APM\jobs;

use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;

class Cache
{
    /**
     * Cache repositories information
     * 
     * @param string[] $urls
     * 
     * @return void
     */
    public static function cacheReposInfo(array $urls): void
    {
        foreach ($urls as $url) {
            if (Internet::getURL($url . "Release.json")->getCode() != 200) {
                return;
            }

            $info = json_decode(Internet::getURL($url . "Release.json")->getBody(), true);

            APM::$reposInfoCache[] = [
                "repo" => $url,
                "label" => $info["label"],
                "suite" => $info["suite"],
                "description" => $info["description"],
            ];
        }
    }

    /**
     * Cache repositories plugins
     * 
     * @param string[] $urls
     * 
     * @return void
     */
    public static function cacheReposPlugins(array $urls): void
    {
        foreach ($urls as $url) {
            if (Internet::getURL($url . "Plugins.json")->getCode() != 200) {
                return;
            }

            $data = json_decode(Internet::getURL($url . "Plugins.json")->getBody(), true);

            foreach ($data as $plugin) {
                APM::$reposPluginsCache[] = [
                    "plugin" => $plugin["plugin"],
                    "name" => $plugin["name"],
                    "author" => $plugin["author"],
                    "version" => $plugin["version"],
                    "description" => $plugin["description"],
                    "download_url" => $plugin["file"],
                    "md5" => $plugin["md5"],
                    "sha1" => $plugin["sha1"],
                    "sha256" => $plugin["sha256"],
                    "sha512" => $plugin["sha512"],
                ];
            }
        }
    }

    /**
     * Cache loaded plugins
     *
     * @return void
     */
    public static function cacheLoadedPlugins(): void
    {
        foreach (APM::getInstance()->getServer()->getPluginManager()->getPlugins() as $plugin) {
            $files = array_diff(scandir(APM::getInstance()->getServer()->getDataPath() . "plugins/"), array(".", ".."));

            foreach ($files as $file) {
                if (str_contains($file, $plugin->getName()) && str_ends_with($file, ".phar") === true) {
                    APM::$loadedPlugins[] = ["name" => $plugin->getName(), "path" => APM::getInstance()->getServer()->getDataPath() . "plugins/" . $file];
                }
            }
        }
    }
}
