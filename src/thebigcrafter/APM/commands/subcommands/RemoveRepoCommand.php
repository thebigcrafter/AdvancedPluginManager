<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Remover;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use thebigcrafter\APM\error\ErrorHandler;

class RemoveRepoCommand extends BaseSubCommand
{
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getRemoveRepoForm());
        } else {
            if (!isset($args["url"])) {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
            if (Remover::removeRepo((string) $args["url"])) {
                $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("remove.repo.success"));
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$URL_NOT_FOUND);
            }
        }
    }

    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("url", false));
    }
}
