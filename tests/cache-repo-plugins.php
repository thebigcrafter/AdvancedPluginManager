<?php

declare(strict_types=1);

namespace pocketmine\scheduler {
	abstract class Task {}
}

namespace pocketmine\utils {
	final class InternetResponseFixture {
		public function __construct(private int $code, private string $body) {}
		public function getCode(): int { return $this->code; }
		public function getBody(): string { return $this->body; }
	}

	final class Internet {
		/** @var array<string, InternetResponseFixture> */
		public static array $responses = [];

		public static function getURL(string $url): ?InternetResponseFixture {
			return self::$responses[$url] ?? null;
		}
	}
}

namespace thebigcrafter\APM {
	final class APM {
		/** @var array<array<string, string>> */
		public static array $reposPluginsCache = [];
	}
}

namespace {
	require __DIR__ . "/../src/tasks/cache/CacheRepoPlugins.php";

	use pocketmine\utils\Internet;
	use pocketmine\utils\InternetResponseFixture;
	use thebigcrafter\APM\APM;
	use thebigcrafter\APM\tasks\cache\CacheRepoPlugins;

	$repo = "https://example.test/";
	$catalog = json_encode([[
		"plugin" => "ExamplePlugin",
		"name" => "Example Plugin",
		"author" => "thebigcrafter",
		"version" => "1.0.0",
		"description" => "A catalog fixture",
		"file" => "https://example.test/ExamplePlugin.phar",
		"md5" => str_repeat("a", 32),
		"sha1" => str_repeat("b", 40),
		"sha256" => str_repeat("c", 64),
		"sha512" => str_repeat("d", 128),
	]], JSON_THROW_ON_ERROR);
	Internet::$responses[$repo . "Plugins.json"] = new InternetResponseFixture(200, $catalog);

	(new CacheRepoPlugins([$repo]))->onRun();
	$entry = APM::$reposPluginsCache[0] ?? [];
	if (($entry["file"] ?? null) !== "https://example.test/ExamplePlugin.phar" || array_key_exists("download_url", $entry)) {
		fwrite(STDERR, "The cached catalog must expose the installer-compatible file key.\n");
		exit(1);
	}

	echo "AdvancedPluginManager repository plugin cache regression passed\n";
}
