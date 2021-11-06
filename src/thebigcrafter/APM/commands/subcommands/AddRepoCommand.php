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
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class AddRepoCommand extends BaseSubCommand
{
    /**
     * @throws ArgumentOrderException
     */
    protected function prepare(): void
    {
        $this->setDescription("Add repository");

        $this->registerArgument(0, new RawStringArgument("url", false));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if ($sender instanceof Player) {
            $sender->sendForm(RepoForm::getAddingForm());
        } else {
            if (!isset($args["url"])) {
                return;
            }
            if (Adder::addRepo($args["url"])) {
                $sender->sendMessage(APM::$PREFIX . TextFormat::GREEN . "Added!");
            } else {
                $sender->sendMessage(APM::$PREFIX . TextFormat::DARK_RED . $args["url"] . " is not a valid URL!");
            }
        }
    }
}
