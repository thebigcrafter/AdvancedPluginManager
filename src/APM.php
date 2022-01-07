<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

use pocketmine\lang\Language;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use thebigcrafter\APM\commands\APMCommand;
use thebigcrafter\APM\tasks\Cache;

class APM extends PluginBase
{
	use SingletonTrait;

	/**
	 * Prefix
	 */
	public static string $PREFIX = "§a[§bAPM§a]§r ";
	/**
	 * Plugins cache
	 *
	 * @var array<array<string, string|int>>
	 */
	public static array $reposPluginsCache = [];
	/**
	 * Repositories information cache
	 *
	 * @var array<array<string, string>>
	 */
	public static array $reposInfoCache = [];
	/**
	 * Loaded plugins list
	 *
	 * @var array<array<string, string>>
	 */
	public static array $loadedPlugins = [];
	/**
	 * Language
	 */
	private static Language $language;
	/**
	 * Repositories list
	 */
	public Config $repos;
	/**
	 * Plugin configurations
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
	 */
	private string $defaultRepo = "https://thebigcrafter.github.io/";

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

		$this->saveDefaultConfig();
		$this->config = $this->getConfig();
		$this->repos = new Config($this->getDataFolder() . "repos.yml", Config::YAML, ["repositories" => [$this->defaultRepo]]);

		$this->initLanguageFiles($this->config->get("language"), $this->languages);
		$this->cacheRepo();
		Cache::cacheLoadedPlugins();

		$this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced Plugin Manager"));
	}

	/**
	 * Initialize language files
	 *
	 * @param string[] $languageFiles
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
	 */
	public function cacheRepo(): void
	{
		$this->reloadConfig();

		Cache::cacheReposInfo($this->repos->get("repositories"));
		Cache::cacheReposPlugins($this->repos->get("repositories"));
	}
}
