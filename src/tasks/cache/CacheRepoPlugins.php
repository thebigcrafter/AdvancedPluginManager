<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks\cache;

use pocketmine\scheduler\Task;
use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;

class CacheRepoPlugins extends Task
{
	/** @var string[] $urls */
	private array $urls;

	/** @var array<array<string, string>> $repoPlugins */
	private array $repoPlugins = [];

	/**
	 * @param string[] $urls
	 */
	public function __construct(array $urls)
	{
		$this->urls = $urls;
	}

	public function onRun(): void
	{
		foreach ($this->urls as $url) {
			if (empty(Internet::getURL($url . "Plugins.json")) || Internet::getURL($url . "Plugins.json")->getCode() != 200) {
				return;
			}

			$data = json_decode(Internet::getURL($url . "Plugins.json")->getBody(), true);

			foreach ($data as $plugin) {
				$this->repoPlugins[] = [
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

		APM::$reposPluginsCache = $this->repoPlugins;
	}
}