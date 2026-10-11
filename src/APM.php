<?php

declare(strict_types=1);

namespace thebigcrafter\APM;

$composerAutoloader = __DIR__ . '/../vendor/autoload.php';
if (is_file($composerAutoloader)) {
	require_once $composerAutoloader;
}

use pocketmine\lang\Language;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use thebigcrafter\APM\commands\APMCommand;
use thebigcrafter\APM\tasks\cache\CacheRepoInfo;
use thebigcrafter\APM\tasks\cache\CacheRepoPlugins;

class APM extends PluginBase
{
	use SingletonTrait;

	/** Prefix */
	public static string $PREFIX = "§a[§bAPM§a]§r ";

	/**
	 * Plugins cache
	 *
	 * @var array<array<string, string>>
	 */
	public static array $reposPluginsCache = [];

	/**
	 * Repositories information cache
	 *
	 * @var array<array<string, string>>
	 */
	public static array $reposInfoCache = [];

	/** Language */
	private static Language $language;

	/** Repositories list */
	public Config $repos;

	/** Plugin configurations */
	public Config $config;

	/**
	 * Language FILE name
	 *
	 * @var array<string>
	 */
	private array $languages = ["eng", "vie", "ind", "rus", "ukr"];

	/** Default repository */
	private string $defaultRepo = "https://thebigcrafter.github.io/";

	public static function getInstance(): self
	{
		$instance = self::$instance;
		if ($instance === null) {
			throw new \LogicException("Advanced Plugin Manager is not initialized.");
		}
		return $instance;
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

		$language = $this->config->get("language");
		$this->initLanguageFiles(is_string($language) ? $language : "eng", $this->languages);
		$this->cacheRepo();

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

		$repositories = $this->getRepositoryUrls();
		$this->getScheduler()->scheduleTask(new CacheRepoInfo($repositories));
		$this->getScheduler()->scheduleTask(new CacheRepoPlugins($repositories));
	}

	/** @return list<string> */
	public function getRepositoryUrls(): array
	{
		$repositories = $this->repos->get("repositories");
		if (!is_array($repositories)) {
			return [$this->defaultRepo];
		}

		$urls = [];
		foreach ($repositories as $repository) {
			if (is_string($repository)) {
				$urls[] = $repository;
			}
		}
		return $urls;
	}
}
