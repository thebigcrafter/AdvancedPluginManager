<?php

declare(strict_types=1);

namespace thebigcrafter\APM\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use thebigcrafter\APM\APM;
use thebigcrafter\APM\forms\RepoForm;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class ListRepoCommand extends BaseSubCommand
{
    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array<string> $args
     *
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            RepoForm::getRepoListForm($sender);
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
    }
}
