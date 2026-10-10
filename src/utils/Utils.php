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

		if (isset($release["label"]) && isset($release["suite"]) && isset($release["codename"]) && isset($release["description"])) {
			return true;
		} else {
			return false;
		}

		// TODO: Check the Plugins.json is valid.
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
