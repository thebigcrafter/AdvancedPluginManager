<?php

declare(strict_types=1);

namespace MintoD\APM\utils;

use pocketmine\utils\Internet;

class Reader {
    public static function readRelease(string $url) {
        if(str_ends_with($url, "/")) {
            return json_decode(Internet::getURL($url . "Release.json"));
        } else {
            return json_decode(Internet::getURL($url . "/Release.json"));
        }
    }
}