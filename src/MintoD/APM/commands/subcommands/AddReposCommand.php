<?php

declare(strict_types=1);

namespace MintoD\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use jojoe77777\FormAPI\CustomForm;
use MintoD\APM\forms\RepoForm;
use MintoD\APM\utils\Notifier;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class AddReposCommand extends BaseSubCommand
{
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getRepoForm());
        } else {
            $sender->sendMessage(Notifier::error("Please use this command in-game"));
        }

    }

    protected function prepare(): void
    {
        $this->setDescription("Add repository");
    }
}