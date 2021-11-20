<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use jojoe77777\FormAPI\SimpleForm;
use thebigcrafter\APM\APM;
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
                    $player->sendForm(RepoForm::getRemoveRepoForm());
                    break;
                case 2:
                    $player->sendForm(RepoForm::getRepoListForm());
                    break;
                case 3:
                    $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("start.update.message"));
                    APM::getInstance()->cacheRepo();
                    $player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("end.update.message"));
                    break;
                case 4:
                    $player->sendForm(RepoForm::getInstallPluginForm());
                    break;
                case 5:
                    $player->sendForm(RepoForm::getRemovePluginForm());
                    break;
            }
        });
        $buttons = [APM::getLanguage()->translateString("add.repo.button"), APM::getLanguage()->translateString("remove.repo.button"), APM::getLanguage()->translateString("list.repo.button"), APM::getLanguage()->translateString("update.button"), APM::getLanguage()->translateString("install.plugin.button"), APM::getLanguage()->translateString("remove.plugin.button")];

        $form->setTitle(APM::getLanguage()->translateString("menu.form.title"));

        foreach ($buttons as $button) {
            $form->addButton($button);
        }

        return $form;
    }
}
