<?php

declare(strict_types=1);

namespace thebigcrafter\APM\utils;

use pocketmine\utils\Internet;

class Utils
{
	/**
	 * Check if the given string is an APM repo URL. NOTE: The URL must end with a slash.
	 *
	 * @return boolean
	 */
	public static function isAPMRepo(string $url): bool
	{
		$releaseResponse = Internet::getURL($url . "Release.json");
		$pluginsResponse = Internet::getURL($url . "Plugins.json");
		if ($releaseResponse === null || $pluginsResponse === null) {
			return false;
		}
		$release = $releaseResponse->getCode();
		$plugins = $pluginsResponse->getCode();

		if ($plugins !== 200 || $release !== 200) {
			return false;
		}

		$release = json_decode($releaseResponse->getBody(), true);
		if (!is_array($release)) {
			return false;
		}

		if (!isset($release["label"]) || !isset($release["suite"]) || !isset($release["codename"]) || !isset($release["description"])) {
			return false;
		}

		$pluginList = json_decode($pluginsResponse->getBody(), true);
		if (!is_array($pluginList)) {
			return false;
		}

		foreach ($pluginList as $plugin) {
			if (!is_array($plugin) || !is_string($plugin["plugin"] ?? null) || !is_string($plugin["name"] ?? null) || !is_string($plugin["author"] ?? null) || !is_string($plugin["version"] ?? null) || !is_string($plugin["description"] ?? null) || !is_string($plugin["file"] ?? null) || !is_string($plugin["md5"] ?? null) || !is_string($plugin["sha1"] ?? null) || !is_string($plugin["sha256"] ?? null) || !is_string($plugin["sha512"] ?? null)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @param array<string> $versions
	 */
	public static function getLatestVersion(array $versions): string
	{
		$latest = "";

		foreach ($versions as $version) {
			if (version_compare($version, $latest) > 0) {
				$latest = $version;
			}
		}

		return $latest;
	}
}
