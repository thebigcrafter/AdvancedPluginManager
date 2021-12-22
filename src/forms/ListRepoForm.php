<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Label;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;

class ListRepoForm {
    /**
     * @return CustomForm
     */
    public static function get(): CustomForm {
        $labels = [];

        foreach (APM::$reposInfoCache as $repo) {
            $labels[] = new Label($repo["repo"], $repo["label"] . "\n" . $repo["description"]);
        }

        return new CustomForm(APM::getLanguage()->translateString("list.repo.form.title"), $labels, function(Player $player, CustomFormResponse $res): void {
            return;
        });
    }
}