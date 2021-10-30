<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\form\Form;
use pocketmine\Player;

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
            }
        });
        $buttons = ["Add repository", "Remove repository", "Repositories list"];

        $form->setTitle("Menu Form");

        foreach ($buttons as $button) {
            $form->addButton($button);
        }

        return $form;
    }
}