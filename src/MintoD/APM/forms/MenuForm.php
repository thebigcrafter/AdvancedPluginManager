<?php

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\form\Form;
use pocketmine\Player;

class MenuForm
{
    public static function getMenuForm(): Form
    {
        $buttonsTitle = ["Help", "Add repository"];

        $form = new SimpleForm(function (Player $player, int $data = null) {
            switch ($data) {
                case 0:
                    $player->sendForm(HelpForm::getHelpForm());
                    break;
                case 1:
                    $player->sendForm(RepoForm::getRepoForm());
                    break;
            }
        });
        foreach ($buttonsTitle as $title) {
            $form->addButton($title);
        }
        return $form;
    }
}