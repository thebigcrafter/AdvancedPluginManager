<?php

declare(strict_types=1);

namespace MintoD\APM;

use MintoD\APM\commands\APMCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class APM extends PluginBase
{

    /**
     * APM's Prefix
     * @var string
     */
    public const PREFIX = "{TOKEN}";
    /**
     * Instance
     * @var self
     */
    public static self $instance;
    /**
     * Repos file
     * @var Config
     */
    public Config $repos;

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register("apm", new APMCommand($this, "apm", "Advanced plugin manager commands"));
        $this->saveDefaultConfig();
        $this->repos = new Config($this->getDataFolder() . "repositories.yml", Config::YAML, array(
            "repositories" => ["https://example.com"]
        ));
        self::$instance = $this;
    }
}