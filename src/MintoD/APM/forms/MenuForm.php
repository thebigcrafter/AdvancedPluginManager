<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use MintoD\APM\APM;
use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class MenuForm
{
    /**
     * Return menu form
     * @return Form
     */
    public static function getMenuForm(): Form
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            switch ($data) {
                case 0:
                    $player->sendForm(RepoForm::getAddingForm());
                    break;
                case 1:
                    $player->sendForm(RepoForm::getRemovingForm());
                    break;
                case 2:
                    $player->sendForm(RepoForm::getListingForm());
                    break;
                case 3:
                    $player->sendMessage(APM::$PREFIX . TextFormat::YELLOW . "Updating...");
                    APM::getInstance()->cacheRepo();
                    $player->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Updated!");
                    break;
            }
        });
        $buttons = ["Add repository", "Remove repository", "Repositories list", "Update repositories"];

        $form->setTitle("Menu Form");

        foreach ($buttons as $button) {
            $form->addButton($button);
        }

        return $form;
    }
}