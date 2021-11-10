<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\jobs\Adder;
use thebigcrafter\APM\jobs\Remover;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\jobs\Installer;

class RepoForm
{
    /**
     * Get adding form
     * @return Form
     */
    public static function getAddingForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (Adder::addRepo($data[0])) {
                $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Added!");
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$INVALID_URL);
            }
        });
        $form->setTitle("Add repository");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * Get remove repo form
     * @return Form
     */
    public static function getRemoveRepoForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (Remover::removeRepo($data[0])) {
                $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Removed!");
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$INVALID_URL);
            }
        });
        $form->setTitle("Remove repository");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * Get repositories list form
     * @return Form
     */
    public static function getRepoListForm(): Form
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
        });
        $repositoriesList = "";
        foreach (APM::$repoCache as $cache) {
            foreach (APM::getInstance()->repos->get("repositories") as $repo) {
                if ($cache["repo"] == $repo) {
                    $repositoriesList = $repositoriesList . "Name: " . $cache["label"] . "\n" . "Codename: " . $cache["codename"] . "\n" . "Repository URL: " . $repo . "\n\n";
                }
            }
        }
        $form->setTitle("Repositories list");
        $form->setContent($repositoriesList);
        return $form;
    }

    /**
     * Get install plugin form
     * @return Form
     */
    public static function getInstallPluginForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (Installer::install($data[0])) {
                $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Installed!");
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        });
        $form->setTitle("Install plugin");
        $form->addInput("Please enter plugin name");
        return $form;
    }

    /**
     * Get remove plugin form
     * @return Form
     */

    public static function getRemovePluginForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (Remover::removePlugin($data[0])) {
                $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Removed!");
            } else {
                ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$PLUGIN_NOT_FOUND);
            }
        });
        $form->setTitle("Remove plugin");
        $form->addInput("Please enter plugin name");
        return $form;
    }
}
