<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\exception\ArgumentOrderException;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\jobs\Adder;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\error\ErrorHandler;

class AddRepoCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("url", false));
    }

    /**
     * @throws \JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getAddingForm());
        } else {
            if (!isset($args["url"])) {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
            if (Adder::addRepo((string) $args["url"])) {
                $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("add.repo.success"));
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
        }
    }
}
