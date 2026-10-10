<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks\cache;

use pocketmine\scheduler\Task;
use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;

class CacheRepoInfo extends Task
{
	/** @var string[] $urls */
	private array $urls;

	/** @var array<array<string, string>> $repoInfo */
	private array $repoInfo = [];

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
			$response = Internet::getURL($url . "Release.json");
			if ($response === null || $response->getCode() !== 200) {
				return;
			}

			$info = json_decode($response->getBody(), true);
			if (!is_array($info) || !is_string($info["label"] ?? null) || !is_string($info["description"] ?? null)) {
				return;
			}

			$this->repoInfo[] = [
				"repo" => $url,
				"label" => $info["label"],
				"description" => $info["description"],
			];
		}

		APM::$reposInfoCache = $this->repoInfo;
	}
}
