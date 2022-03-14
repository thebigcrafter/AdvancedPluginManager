<?php

declare(strict_types=1);

namespace thebigcrafter\APM\forms;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\tasks\Adder;

class AddRepoForm
{

	public static function get(): CustomForm
	{
		return new CustomForm(APM::getLanguage()->translateString("add.repo.form.title"), [
			new Input("pluginName", APM::getLanguage()->translateString("add.repo.form.input"))
		], function (Player $player, CustomFormResponse $res): void {
			if (empty($res->getString("pluginName"))) {
				return;
			}

			if (Adder::addRepo($res->getString("pluginName"))) {
				$player->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("add.repo.success"));
			} else {
				ErrorHandler::sendErrorToPlayer($player, ErrorHandler::$INVALID_URL);
			}
		});
	}
}