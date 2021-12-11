<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\MenuForm as PmformsMenuForm;
use dktapps\pmforms\MenuOption;
use thebigcrafter\APM\APM;
use pocketmine\form\Form;
use pocketmine\player\Player;

class MenuForm
{
    /**
     * Return menu form
     * @return PmformsMenuForm
     */
    public static function getMenuForm(): PmformsMenuForm
    {
        $buttons = [];

        foreach ([APM::getLanguage()->translateString("add.repo.button"), APM::getLanguage()->translateString("remove.repo.button"), APM::getLanguage()->translateString("list.repo.button"), APM::getLanguage()->translateString("update.button"), APM::getLanguage()->translateString("install.plugin.button"), APM::getLanguage()->translateString("remove.plugin.button")] as $name) {
            $buttons[] = new MenuOption($name);
        }

        $form = new PmformsMenuForm(APM::getLanguage()->translateString("menu.form.title"), "", $buttons, function (Player $player, int $selected): void {
            switch ($selected) {
                case 0:
                    $player->sendForm(RepoForm::getAddingForm());
                    break;
                case 1:
                    $player->sendForm(RepoForm::getRemoveRepoForm());
                    break;
                case 2:
                    // TODO: Move this to get repo list command
                    RepoForm::getRepoListForm($player);
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
        return $form;
    }
}
