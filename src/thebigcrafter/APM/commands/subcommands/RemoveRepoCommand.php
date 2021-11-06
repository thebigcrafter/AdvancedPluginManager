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

class RemoveRepoCommand extends BaseSubCommand
{
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getRemovingForm());
        } else {
            if (!isset($args["url"])) {
                return;
            }
            if (Remover::removeRepo($args["url"])) {
                $sender->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Removed!");
            } else {
                $sender->sendMessage(APM::$PREFIX . TextFormat::DARK_RED . $args["url"] . " not found!");
            }
        }
    }

    protected function prepare(): void
    {
        $this->setDescription("Remove repository");

        $this->registerArgument(0, new RawStringArgument("url", false));
    }
}
