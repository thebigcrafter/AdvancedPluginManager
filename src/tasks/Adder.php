<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks;

use JsonException;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\utils\Utils;

class Adder
{
	/**
	 * Add repo. If url is valid, return true else return false
	 *
	 * @throws JsonException
	 */
	public static function addRepo(string $url): bool
	{
		if (filter_var($url, FILTER_VALIDATE_URL)) {
			if (!str_ends_with($url, "/")) {
				$url .= "/";
			}

			if (!Utils::isAPMRepo($url)) {
				return false;
			}

			$reposFile = APM::getInstance()->repos;
			$repos = $reposFile->get("repositories");
			$repos[] = $url;
			$reposFile->set("repositories", $repos);
			$reposFile->save();
			return true;
		} else {
			return false;
		}
	}
}
