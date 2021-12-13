<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\jobs\Adder;
use thebigcrafter\APM\jobs\Remover;
use pocketmine\player\Player;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\jobs\Installer;

class RepoForm
{
    /**
     * Get adding form
     *
     * @return CustomForm
     */
    public static function getAddingForm(): CustomForm
    {
        return new CustomForm(APM::getLanguage()->translateString("add.repo.form.title"), [
            new Input("pluginName", APM::getLanguage()->translateString("add.repo.form.input"))
        ], function (Player $player, CustomFormResponse $res): void {
            if ($res->getString("pluginName") === null) {
                return;
            }

            if (Adder::addRepo($res->getString("pluginName"))) {
                $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("add.repo.success"));
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$INVALID_URL);
            }
        });
    }

    /**
     * Get remove repo form
     *
     * @return CustomForm
     */
    public static function getRemoveRepoForm(): CustomForm
    {
        return new CustomForm(APM::getLanguage()->translateString("remove.repo.form.title"), [
            new Input("pluginName", APM::getLanguage()->translateString("remove.repo.form.input"))
        ], function (Player $player, CustomFormResponse $res): void {
            if ($res->getString("pluginName") === null) {
                return;
            }

            if (Remover::removeRepo($res->getString("pluginName"))) {
                $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("remove.repo.success"));
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$INVALID_URL);
            }
        });
    }

    /**
     * Get repositories list form
     *
     * @param Player $player
     *
     * @return void
     */
    public static function getRepoListForm(Player $player): void
    {
        $repositoriesList = "";
        foreach (APM::$reposInfoCache as $cache) {
            foreach (APM::getInstance()->repos->get("repositories") as $repo) {
                if ($cache["repo"] == $repo) {
                    $repositoriesList = $repositoriesList . "Name: " . $cache["label"] . "\n" . "Description: " . $cache["description"] . "\n" . "Repository URL: " . $repo . "\n\n";
                }
            }
        }
        $player->sendMessage($repositoriesList);
    }

    /**
     * Get install plugin form
     *
     * @return CustomForm
     */
    public static function getInstallPluginForm(): CustomForm
    {
        return new CustomForm(APM::getLanguage()->translateString("install.plugin.form.title"), [
            new Input("pluginName", APM::getLanguage()->translateString("install.plugin.form.input"))
        ], function (Player $player, CustomFormResponse $res): void {
            if ($res->getString("pluginName") === null) {
                return;
            }

            if (Installer::install($res->getString("pluginName"))) {
                $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("install.plugin.success"));
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        });
    }

    /**
     * Get remove plugin form
     * @return CustomForm
     */
    public static function getRemovePluginForm(): CustomForm
    {
        return new CustomForm(APM::getLanguage()->translateString("remove.plugin.form.title"), [
            new Input("pluginName", APM::getLanguage()->translateString("remove.plugin.form.input"))
        ], function (Player $player, CustomFormResponse $res): void {
            if ($res->getString("pluginName") === null) {
                return;
            }

            if (Remover::removePlugin($res->getString("pluginName"))) {
                $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("remove.plugin.success"));
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        });
    }
}
