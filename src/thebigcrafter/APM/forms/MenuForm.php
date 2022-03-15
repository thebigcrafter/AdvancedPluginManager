<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\MenuOption;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\APM;

class MenuForm
{

	public static function get(): \dktapps\pmforms\MenuForm
	{
		$buttons = [];

		foreach ([TextFormat::colorize(APM::getLanguage()->translateString("add.repo.button")), TextFormat::colorize(APM::getLanguage()->translateString("remove.repo.button")), TextFormat::colorize(APM::getLanguage()->translateString("list.repo.button")), TextFormat::colorize(APM::getLanguage()->translateString("update.button")), TextFormat::colorize(APM::getLanguage()->translateString("install.plugin.button")), TextFormat::colorize(APM::getLanguage()->translateString("remove.plugin.button")), TextFormat::colorize(APM::getLanguage()->translateString("list.plugin.button"))] as $name) {
			$buttons[] = new MenuOption($name);
		}

		return new \dktapps\pmforms\MenuForm(TextFormat::colorize(APM::getLanguage()->translateString("menu.form.title")), "", $buttons, function (Player $player, int $selected): void {
			switch ($selected) {
				case 0:
					$player->sendForm(AddRepoForm::get());
					break;
				case 1:
					$player->sendForm(RemoveRepoForm::get());
					break;
				case 2:
					$player->sendForm(ListRepoForm::get());
					break;
				case 3:
					$player->sendMessage(TextFormat::colorize(APM::$PREFIX . APM::getLanguage()->translateString("start.update.message")));
					APM::getInstance()->cacheRepo();
					$player->sendMessage(TextFormat::colorize(APM::$PREFIX . APM::getLanguage()->translateString("end.update.message")));
					break;
				case 4:
					$player->sendForm(InstallPluginForm::get());
					break;
				case 5:
					$player->sendForm(RemovePluginForm::get());
					break;
				case 6:
					foreach (APM::$reposPluginsCache as $plugin) {
						$player->sendMessage($plugin["name"]);
					}
					break;
			}
		});
	}
}