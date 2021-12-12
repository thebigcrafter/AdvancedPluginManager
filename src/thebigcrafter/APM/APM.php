<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

use pocketmine\lang\Language;
use thebigcrafter\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use thebigcrafter\APM\jobs\Cache;

class APM extends PluginBase
{
    use SingletonTrait;

    /**
     * Language FILE name
     *
     * @var array<string>
     */
    private array $languages = ["eng", "vie"];

    /**
     * Default repository
     * @var string
     */
    private string $defaultRepo = "https://thebigcrafter.github.io/";

    /**
     * Prefix
     *
     * @var string
     */
    public static string $PREFIX = "§a[§bAPM§a]§r ";

    /**
     * Repositories list
     */
    public Config $repos;

    /**
     * Plugin config
     *
     * @var Config
     */
    public Config $config;

    /**
     * Plugins cache
     *
     * @var string[]
     */
    public static array $reposPluginsCache = [];

    /**
     * Repositories information cache
     * 
     * @var string[]
     */
    public static array $reposInfoCache = [];

    /**
     * Loaded plugins list
     *
     * @var array
     */
    public static array $loadedPlugins = [];

    /**
     * Language
     *
     * @var Language
     */
    private static Language $language;

    /**
     * Get instance
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public static function getLanguage(): Language
    {
        return self::$language;
    }

    public function onEnable(): void
    {
        self::setInstance($this);

        $this->initConfig();
        $this->initLanguageFiles($this->config->get("language"), $this->languages);
        $this->cacheRepo();
        Cache::cacheLoadedPlugins();

        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));

    }

    /**
     * Initialize config
     *
     * @return void
     */
    public function initConfig(): void
    {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->repos = new Config($this->getDataFolder() . "repos.yml", Config::YAML, array("repositories" => [$this->defaultRepo]));
    }

    /**
     * Cache repositories information
     *
     * @return void
     */
    public function cacheRepo(): void
    {
        $this->reloadConfig();

        Cache::cacheReposInfo($this->repos->get("repositories"));

        $this->cachePlugin();
    }

    /**
     * Cache plugins from repositories
     *
     * @return void
     */
    public function cachePlugin(): void
    {
        Cache::cacheReposPlugins($this->repos->get("repositories"));
    }

    /**
     * Initialize language files
     *
     * @param string $lang
     * @param string[] $languageFiles
     *
     * @return void
     */
    public function initLanguageFiles(string $lang, array $languageFiles): void
    {
        if (!is_dir($this->getDataFolder() . "lang/")) {
            @mkdir($this->getDataFolder() . "lang/");
        }

        foreach ($languageFiles as $file) {
            if (!is_file($this->getDataFolder() . "lang/" . $file . ".ini")) {
                $this->saveResource("lang/" . $file . ".ini");
            }
        }

        self::$language = new Language($lang, $this->getDataFolder() . "lang/");
    }
}
