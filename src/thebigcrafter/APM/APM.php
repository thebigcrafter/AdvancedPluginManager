<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

use thebigcrafter\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\Internet;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class APM extends PluginBase
{
    use SingletonTrait;
    /**
     * APM's prefix
     * @var string
     */
    public static string $PREFIX = "§a[§bAPM§a]§r ";

    /**
     * Repositories cache
     * @var array
     */
    public static array $repoCache = [];

    /**
     * Plugins cache
     * @return array
     */
    public static array $pluginCache = [];

    /**
     * Repositories
     * @var Config
     */
    public Config $repos;

    /**
     * Default repository
     * @var string
     */
    private string $defaultRepo = "https://thebigcrafter.github.io/";

    public function onEnable()
    {
        $this->initConfig();
        $this->cacheRepo();

        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));

        self::setInstance($this);
    }

    public function initConfig()
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->repos = new Config($this->getDataFolder() . "repos.yml", Config::YAML, array("repositories" => [$this->defaultRepo]));
    }

    public function cacheRepo()
    {
        $this->reloadConfig();

        $repositories = $this->repos->get("repositories");
        foreach ($repositories as $repo) {
            $this->getLogger()->info(TextFormat::YELLOW . "Caching repository: " . TextFormat::RESET . $repo);

            if (str_ends_with($repo, "/")) {
                $cache = Internet::getURL($repo . "Release.json");
            } else {
                $cache = Internet::getURL($repo . "/Release.json");
            }

            $json = json_decode($cache);

            self::$repoCache[] = [
                "repo" => $repo,
                "label" => $json->label,
                "suite" => $json->suite,
                "codename" => $json->codename
            ];
        }

        $this->cachePlugin();
    }

    public function cachePlugin()
    {
        foreach ($this->repos->get("repositories") as $repo) {
            if (str_ends_with($repo, "/")) {
                $cache = Internet::getURL($repo . "Plugins.json");
            } else {
                $cache = Internet::getURL($repo . "/Plugins.json");
            }

            $plugins = json_decode($cache, true);

            self::$repoCache[] = [$cache];

            foreach ($plugins as $plugin) {
                self::$pluginCache[] = [
                    "plugins" => $plugin["plugin"],
                    "name" => $plugin["name"],
                    "author" => $plugin["author"],
                    "version" => $plugin["version"],
                    "file" => $plugin["file"],
                    "md5" => $plugin["md5"],
                    "sha1" => $plugin["sha1"],
                    "sha256" => $plugin["sha256"],
                    "sha512" => $plugin["sha512"]
                ];
            }
        }
    }
}
