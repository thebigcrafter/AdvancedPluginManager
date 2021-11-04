<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\RepoForm;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class ListRepoCommand extends BaseSubCommand
{
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getListingForm());
        } else {
            $repositoriesList = "";
            foreach (APM::getInstance()->repos->get("repositories") as $repo) {
                $repositoriesList = $repositoriesList . $repo . "\n";
            }
            $sender->sendMessage($repositoriesList);
        }
    }

    protected function prepare(): void
    {
        $this->setDescription("List repositories");
    }
}