<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\SimpleForm;
use MintoD\APM\APM;
use MintoD\APM\jobs\Adder;
use MintoD\APM\jobs\Remover;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

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
                $player->sendMessage(APM::$PREFIX . TextFormat::DARK_RED . $data[0] . " is not a valid URL!");
            }
        });
        $form->setTitle("Add repository");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * Get removing form
     * @return Form
     */
    public static function getRemovingForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            if (Remover::removeRepo($data[0])) {
                $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Removed!");
            } else {
                $player->sendMessage(APM::$PREFIX . TextFormat::DARK_RED . $data[0] . " not found!");
            }
        });
        $form->setTitle("Remove repository");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * Get listing form
     * @return Form
     */
    public static function getListingForm(): Form
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
}