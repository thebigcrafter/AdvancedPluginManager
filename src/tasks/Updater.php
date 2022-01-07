<?php

declare(strict_types=1);

namespace thebigcrafter\APM\tasks;

use thebigcrafter\APM\APM;

class Updater
{
	public static function updateRepo(): void
	{
		APM::getInstance()->cacheRepo();
		Cache::cacheLoadedPlugins();
	}

	public static function updatePlugin(string $plugin): bool
	{
		return Installer::install($plugin);
	}
}
