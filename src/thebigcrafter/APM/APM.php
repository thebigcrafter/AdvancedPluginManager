<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

use pocketmine\lang\Language;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use thebigcrafter\APM\commands\APMCommand;
use thebigcrafter\APM\jobs\Cache;

class APM extends PluginBase
{
    use SingletonTrait;

    /**
     * Prefix
     *
     * @var string
     */
    public static string $PREFIX = "§a[§bAPM§a]§r ";
    /**
     * Plugins cache
     *
     * @var array<string, mixed>
     */
    public static array $reposPluginsCache = [];
    /**
     * Repositories information cache
     *
     * @var array<string, mixed>
     */
    public static array $reposInfoCache = [];
    /**
     * Loaded plugins list
     *
     * @var array<string, string>
     */
    public static array $loadedPlugins = [];
    /**
     * Language
     *
     * @var Language
     */
    private static Language $language;
    /**
     * Repositories list
     *
     * @var Config
     */
    public Config $repos;
    /**
     * Plugin configurations
     *
     * @var Config
     */
    public Config $config;
    /**
     * Language FILE name
     *
     * @var array<string>
     */
    private array $languages = ["eng", "vie"];
    /**
     * Default repository
     *
     * @var string
     */
    private string $defaultRepo = "https://thebigcrafter.github.io/";

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * @return Language
     */
    public static function getLanguage(): Language
    {
        return self::$language;
    }

    public function onEnable(): void
    {
        self::setInstance($this);

        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->repos = new Config($this->getDataFolder() . "repos.yml", Config::YAML, array("repositories" => [$this->defaultRepo]));

        $this->initLanguageFiles($this->config->get("language"), $this->languages);
        $this->cacheRepo();
        Cache::cacheLoadedPlugins();

        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));
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

    /**
     * Cache repositories data
     *
     * @return void
     */
    public function cacheRepo(): void
    {
        $this->reloadConfig();

        Cache::cacheReposInfo($this->repos->get("repositories"));
        Cache::cacheReposPlugins($this->repos->get("repositories"));
    }
}
