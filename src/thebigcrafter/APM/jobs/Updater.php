<?php

declare(strict_types=1);

namespace thebigcrafter\APM\jobs;

use thebigcrafter\APM\APM;

class Updater
{
    public static function updateRepo(): void
    {
        APM::getInstance()->cacheRepo();
        Cache::cacheLoadedPlugins();
    }
}
