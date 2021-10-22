<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\form\Form;
use pocketmine\Player;

class HelpForm
{
    public static function getHelpForm(): Form
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
        });
        $form->setTitle("Commands list | Advanced Plugin Manager");
        $form->setContent("/apm help To see commands list\n/apm install <plugin name> To install plugin\n/apm remove <plugin name To remove plugin\n/apm add-repository <url>\n/apm update To update all repositories\n/apm upgrade To upgrade all plugins");
        return $form;
    }
}