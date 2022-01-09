<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks;

use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;

class Cache
{
	/**
	 * Cache repositories information
	 *
	 * @param string[] $urls
	 */
	public static function cacheReposInfo(array $urls): void
	{
		foreach ($urls as $url) {
			if (empty(Internet::getURL($url . "Release.json")) || Internet::getURL($url . "Release.json")->getCode() != 200) {
				return;
			}

			$info = json_decode(Internet::getURL($url . "Release.json")->getBody(), true);

			APM::$reposInfoCache[] = [
				"repo" => $url,
				"label" => $info["label"],
				"description" => $info["description"],
			];
		}
	}

	/**
	 * Cache repositories plugins
	 *
	 * @param string[] $urls
	 */
	public static function cacheReposPlugins(array $urls): void
	{
		foreach ($urls as $url) {
			if (empty(Internet::getURL($url . "Plugins.json")) || Internet::getURL($url . "Plugins.json")->getCode() != 200) {
				return;
			}

			$data = json_decode(Internet::getURL($url . "Plugins.json")->getBody(), true);

			foreach ($data as $plugin) {
				APM::$reposPluginsCache[] = [
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
	}
}