<?php

declare(strict_types=1);

namespace MintoD\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use MintoD\APM\APM;
use MintoD\APM\forms\RepoForm;
use MintoD\APM\utils\Notifier;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class RemoveRepoCommand extends BaseSubCommand {
    protected function prepare(): void
    {
        $this->setDescription("Remove repository");
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if($sender instanceof Player) {
            $sender->sendForm(RepoForm::getDeletingForm(APM::getInstance()->repos));
        } else {
            $sender->sendMessage(Notifier::error("Please use this command in-game"));
        }
    }
}