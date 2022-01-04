<?php

namespace thebigcrafter\APM\tasks;

use thebigcrafter\APM\APM;

class Remover
{
    /**
     * Remove repo. If removed, return true else if it cannot find repo return false
     *
     * @param string $url
     * @return bool
     *
     * @throws \JsonException
     */
    public static function removeRepo(string $url): bool
    {
        $repositories = APM::getInstance()->repos;
        $repositoriesList = $repositories->get("repositories");
        if (in_array($url, $repositoriesList)) {
            unset($repositoriesList[array_search($url, $repositoriesList)]);
            $repositories->set("repositories", $repositoriesList);
            $repositories->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove plugin. If removed, return true else if it cannot find plugin return false
     *
     * @param string $name
     *
     * @return bool
     */
    public static function removePlugin(string $name): bool
    {
        $result = false;

        foreach (APM::$loadedPlugins as $plugin) {
            if ($name == $plugin["name"]) {
                unlink($plugin["path"]);
                $result = true;
            }
        }
        return $result;
    }
}
