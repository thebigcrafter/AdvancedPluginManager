<?php

declare(strict_types=1);

namespace MintoD\APM;

use MintoD\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\Internet;
use pocketmine\utils\TextFormat;

class APM extends PluginBase
{
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
     * Instance of the plugin
     * @var self
     */
    private static self $instance;
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

    /**
     * Get the instance of the plugin
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function onEnable()
    {
        $this->initConfig();
        $this->cacheRepo();

        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));

        self::$instance = $this;
    }

    public function initConfig()
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->repos = new Config($this->getDataFolder() . "repos.yml", Config::YAML, array("repositories" => [$this->defaultRepo]));
    }

    public function cacheRepo()
    {
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
    }
}
