<?php

declare(strict_types=1);

namespace MintoD\APM\forms;

use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\Form;
use jojoe77777\FormAPI\SimpleForm;
use MintoD\APM\utils\Notifier;
use MintoD\APM\utils\Reader;
use pocketmine\Player;
use pocketmine\utils\Config;

class RepoForm
{
    /**
     * @param Config $repos
     * @return Form
     */
    public static function getAddingForm(Config $repos): Form
    {
        $form = new CustomForm(function (Player $player, array $data = null) use ($repos) {
            if (filter_var($data[0], FILTER_VALIDATE_URL)) {
                $repositories = $repos->get("repositories");
                $repositories[] = (string)$data[0];
                $repos->set("repositories", $repositories);
                $repos->save();
                $player->sendMessage(Notifier::info("Added!"));
            } else {
                $player->sendMessage(Notifier::error($data[0] . " is not a valid URL!"));
            }
        });
        $form->setTitle("Add repository | Advanced Plugin Manager");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * @param Config $repos
     * @return Form
     */
    public static function getDeletingForm(Config $repos): Form {
        $form = new CustomForm(function (Player $player, array $data = null) use ($repos) {
            $repositoriesList = $repos->get("repositories");
            if(in_array($data[0], $repositoriesList)) {
                unset($repositoriesList[array_search($data[0], $repositoriesList)]);
                $repos->set("repositories", $repositoriesList);
                $repos->save();
                $player->sendMessage(Notifier::info("Removed!"));
            } else {
                $player->sendMessage(Notifier::error("Cannot found a repository"));
            }
        });
        $form->setTitle("Delete repository | Advanced Plugin Manager");
        $form->addInput("Please enter repository URL");
        return $form;
    }

    /**
     * @param Config $repos
     * @return Form
     */
    public static function getListForm(Config $repos): Form
    {
        $form = new SimpleForm(function (Player $player, int $data = null) {
        });
        $repositoriesList = "";
        foreach ($repos->get("repositories") as $repo) {
            $repoInfo = Reader::readRelease($repo);
            $repositoriesList = $repositoriesList . "Name: " . $repoInfo->label . "\n" . "Codename: " . $repoInfo->codename . "\n" . "Repository URL: " . $repo . "\n\n";
        }
        $form->setTitle("Repositories List | Advanced Plugin Manager");
        $form->setContent($repositoriesList);
        return $form;
    }
}