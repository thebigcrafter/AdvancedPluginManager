<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Adder;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\error\ErrorHandler;

class AddRepoCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("url", false));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getAddingForm());
        } else {
            if (!isset($args["url"])) {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
            if (Adder::addRepo((string) $args["url"])) {
                $sender->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Added!");
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
        }
    }
}
