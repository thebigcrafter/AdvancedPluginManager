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
			$response = Internet::getURL($url . "Plugins.json");
			if ($response === null || $response->getCode() !== 200) {
				return;
			}

			$data = json_decode($response->getBody(), true);
			if (!is_array($data)) {
				return;
			}

			foreach ($data as $plugin) {
				if (!is_array($plugin) || !is_string($plugin["plugin"] ?? null) || !is_string($plugin["name"] ?? null) || !is_string($plugin["author"] ?? null) || !is_string($plugin["version"] ?? null) || !is_string($plugin["description"] ?? null) || !is_string($plugin["file"] ?? null) || !is_string($plugin["md5"] ?? null) || !is_string($plugin["sha1"] ?? null) || !is_string($plugin["sha256"] ?? null) || !is_string($plugin["sha512"] ?? null)) {
					continue;
				}
				$this->repoPlugins[] = [
					"plugin" => $plugin["plugin"],
					"name" => $plugin["name"],
					"author" => $plugin["author"],
					"version" => $plugin["version"],
					"description" => $plugin["description"],
					"file" => $plugin["file"],
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
