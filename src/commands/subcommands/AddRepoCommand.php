<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\exception\ArgumentOrderException;
use JsonException;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\error\ErrorHandler;
use thebigcrafter\APM\forms\AddRepoForm;
use thebigcrafter\APM\forms\RepoForm;
use thebigcrafter\APM\tasks\Adder;

class AddRepoCommand extends BaseSubCommand
{
    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<string> $args
     *
     * @return void
     *
     * @throws JsonException
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(AddRepoForm::get());
        } else {
            if (!isset($args["url"])) {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
            if (Adder::addRepo((string)$args["url"])) {
                $sender->sendMessage(APM::$PREFIX . APM::getLanguage()->translateString("add.repo.success"));
            } else {
                ErrorHandler::sendErrorToConsole(ErrorHandler::$INVALID_URL);
            }
        }
    }

    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->registerArgument(0, new RawStringArgument("url", false));
    }
}
