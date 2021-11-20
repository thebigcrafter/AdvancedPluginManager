<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

use pocketmine\lang\BaseLang;
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
     * APM's prefix
     *
     * @var string
     */
    public static string $PREFIX = "§a[§bAPM§a]§r ";

    /**
     * Repositories list
     *
     * @var Config
     */
    public Config $repos;

    /**
     * Plugin's config
     *
     * @var Config
     */
    public Config $config;

    /**
     * Repositories information cache
     *
     * @var array<mixed>
     */
    public static array $repoCache = [];

    /**
     * Plugins information cache
     *
     * @var array<mixed>
     */
    public static array $pluginCache = [];

    /**
     * Loaded plugins list
     *
     * @var array<mixed>
     */
    public static array $loadedPlugins = [];

    /**
     * Language
     *
     * @var BaseLang
     */
    private static BaseLang $language;

    /**
     * Get instance
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    public static function getLanguage(): BaseLang
    {
        return self::$language;
    }

    public function onEnable(): void
    {
        $this->initConfig();
        $this->initLanguageFiles($this->config->get("language"), $this->languages);
        $this->cacheRepo();
        $this->cacheLoadedPlugin();

        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));

        self::setInstance($this);
    }

    /**
     * Initialize config
     *
     * @return void
     */
    public function initConfig(): void
    {
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
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

    /**
     * Cache plugins from repositories
     *
     * @return void
     */
    public function cachePlugin(): void
    {
        foreach ($this->repos->get("repositories") as $repo) {
            if (str_ends_with($repo, "/")) {
                $cache = Internet::getURL($repo . "Plugins.json");
            } else {
                $cache = Internet::getURL($repo . "/Plugins.json");
            }

            $plugins = json_decode($cache, true);

            self::$pluginCache[] = [$cache];

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

    /**
     * Cache loaded plugins
     *
     * @return void
     */
    public function cacheLoadedPlugin(): void
    {
        foreach ($this->getServer()->getPluginManager()->getPlugins() as $plugin) {
            $files = array_diff(scandir($this->getServer()->getDataPath() . "plugins/"), array(".", ".."));

            foreach ($files as $file) {
                if (strpos($file, $plugin->getName()) !== false && str_ends_with($file, ".phar") === true) {
                    self::$loadedPlugins[] = ["name" => $plugin->getName(), "path" => $this->getServer()->getDataPath() . "plugins/" . $file];
                }
            }
        }
    }

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

        self::$language = new BaseLang($lang, $this->getDataFolder() . "lang/");
    }
}
