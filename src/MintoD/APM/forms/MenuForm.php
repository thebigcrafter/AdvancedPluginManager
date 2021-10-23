<?php

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use MintoD\APM\APM;
use pocketmine\form\Form;
use pocketmine\Player;

class MenuForm
{
    public static function getMenuForm(): Form
    {
        $buttonsTitle = ["Help", "List repositories", "Add repository", "Remove repository"];

        $form = new SimpleForm(function (Player $player, int $data = null) {
            switch ($data) {
                case 0:
                    $player->sendForm(HelpForm::getHelpForm());
                    break;
                case 1:
                    $player->sendForm(RepoForm::getListForm(APM::getInstance()->repos));
                    break;
                case 2:
                    $player->sendForm(RepoForm::getAddingForm(APM::getInstance()->repos));
                    break;
                case 3:
                    $player->sendForm(RepoForm::getDeletingForm(APM::getInstance()->repos));
                    break;
            }
        });
        $form->setTitle("Menu | Advanced Plugin Manager");
        foreach ($buttonsTitle as $title) {
            $form->addButton($title);
        }
        return $form;
    }
}