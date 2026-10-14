<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks;

use pocketmine\utils\Internet;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\utils\Utils;

class Installer
{
	/**
	 * Install the plugin. Returns true if plugin is installed, false otherwise.
	 *
	 * @param bool $replaceExisting Replace an existing plugin file atomically.
	 */
	public static function install(string $pluginName, bool $replaceExisting = false): bool
	{
		$pluginVers = [];
		$pluginDownloadURL = "";
		$hash = null;

		foreach (APM::$reposPluginsCache as $plugin) {
			if ($plugin["name"] === $pluginName) {
				$pluginVers[] = $plugin["version"];
			}
		}

		$latestVersion = Utils::getLatestVersion($pluginVers);
		if ($latestVersion === "") {
			return false;
		}

		foreach (APM::$reposPluginsCache as $plugin) {
			if ($plugin["name"] === $pluginName && $plugin["version"] === $latestVersion) {
				$pluginDownloadURL = $plugin["file"];
				$hash = ["md5" => $plugin["md5"], "sha1" => $plugin["sha1"], "sha256" => $plugin["sha256"], "sha512" => $plugin["sha512"]];
			}
		}
		if ($pluginDownloadURL === "" || $hash === null) {
			return false;
		}

		$filePath = APM::getInstance()->getServer()->getDataPath() . "plugins/" . basename($pluginDownloadURL);

		if (is_file($filePath) && !$replaceExisting) {
			return false;
		}

		$response = Internet::getURL($pluginDownloadURL);
		if ($response === null) {
			return false;
		}
		$temporaryPath = $filePath . ".part";
		if (file_put_contents($temporaryPath, $response->getBody()) === false) {
			return false;
		}

		$md5 = md5_file($temporaryPath);
		$sha1 = sha1_file($temporaryPath);
		$sha256 = hash_file("sha256", $temporaryPath);
		$sha512 = hash_file("sha512", $temporaryPath);
		if (is_string($md5) && is_string($sha1) && is_string($sha256) && is_string($sha512) && $hash["md5"] === $md5 && $hash["sha1"] === $sha1 && $hash["sha256"] === $sha256 && $hash["sha512"] === $sha512) {
			return rename($temporaryPath, $filePath);
		} else {
			unlink($temporaryPath);
			return false;
		}
	}
}
