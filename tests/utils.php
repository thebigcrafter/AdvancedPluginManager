<?php

declare(strict_types=1);

namespace pocketmine\utils {
	final class InternetResponseFixture
	{
		public function __construct(private int $code, private string $body)
		{
		}

		public function getCode(): int
		{
			return $this->code;
		}

		public function getBody(): string
		{
			return $this->body;
		}
	}

	final class Internet
	{
		/** @var array<string, InternetResponseFixture> */
		public static array $responses = [];

		public static function getURL(string $url): ?InternetResponseFixture
		{
			return self::$responses[$url] ?? null;
		}
	}
}

namespace {
	require_once dirname(__DIR__) . "/src/utils/Utils.php";

	use pocketmine\utils\Internet;
	use thebigcrafter\APM\utils\Utils;

	$baseUrl = "https://example.test/";
	$release = json_encode([
		"label" => "Example",
		"suite" => "Example Suite",
		"codename" => "example",
		"description" => "Example repository",
	], JSON_THROW_ON_ERROR);
	$plugin = [
		"plugin" => "ExamplePlugin",
		"name" => "Example Plugin",
		"author" => "Example Author",
		"version" => "1.0.0",
		"description" => "Example plugin",
		"file" => "https://example.test/ExamplePlugin.phar",
		"md5" => "md5",
		"sha1" => "sha1",
		"sha256" => "sha256",
		"sha512" => "sha512",
	];

	$setResponses = static function (string $plugins) use ($baseUrl, $release): void {
		Internet::$responses = [
			$baseUrl . "Release.json" => new \pocketmine\utils\InternetResponseFixture(200, $release),
			$baseUrl . "Plugins.json" => new \pocketmine\utils\InternetResponseFixture(200, $plugins),
		];
	};
	$assert = static function (bool $expected, string $message) use ($baseUrl): void {
		$actual = Utils::isAPMRepo($baseUrl);
		if ($actual !== $expected) {
			throw new \RuntimeException($message);
		}
	};

	$setResponses(json_encode([$plugin], JSON_THROW_ON_ERROR));
	$assert(true, "A valid plugin catalog must be accepted");

	$invalidPlugin = $plugin;
	unset($invalidPlugin["sha256"]);
	$setResponses(json_encode([$invalidPlugin], JSON_THROW_ON_ERROR));
	$assert(false, "A plugin catalog with missing required fields must be rejected");

	$setResponses("not-json");
	$assert(false, "An invalid plugin catalog must be rejected");

	echo "AdvancedPluginManager repository validation regression passed\n";
}
