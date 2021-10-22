<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\Form;
use pocketmine\Player;

class RepoForm
{
    public static function getRepoForm(): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) {
            // TODO: Make a file to store all repo urls
            $player->sendMessage($data[0]);
        });
        $form->setTitle("Add repository | Advanced Plugin Manager");
        $form->addInput("Please enter repository URL");
        return $form;
    }
}