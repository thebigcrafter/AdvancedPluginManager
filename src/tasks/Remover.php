<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks;

use thebigcrafter\APM\APM;

class Remover
{
	/**
	 * Remove repo. If removed, return true else if it cannot find repo return false
	 *
	 * @throws \JsonException
	 */
	public static function removeRepo(string $url): bool
	{
		$repositories = APM::getInstance()->repos;
		$repositoriesList = $repositories->get("repositories");
		if (in_array($url, $repositoriesList, true)) {
			unset($repositoriesList[array_search($url, $repositoriesList, true)]);
			$repositories->set("repositories", $repositoriesList);
			$repositories->save();
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Remove plugin. If removed, return true else if it cannot find plugin return false
	 */
	public static function removePlugin(string $name): bool
	{
		$result = false;

		if(file_exists(APM::getInstance()->getServer()->getDataPath() . "plugins/" . $name . ".phar")) {
			unlink(APM::getInstance()->getServer()->getDataPath() . "plugins/" . $name . ".phar");
			$result = true;
		}

		return $result;
	}
}
