<?php

declare(strict_types=1);

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
	final class TestServer {
		public function __construct(private string $dataPath) {}

		public function getDataPath(): string { return $this->dataPath; }
	}

	final class APM {
		/** @var list<array<string, string>> */
		public static array $reposPluginsCache = [];
		public static ?self $instance = null;
		public function __construct(private TestServer $server) {}

		public static function getInstance(): self { return self::$instance; }
		public function getServer(): TestServer { return $this->server; }
	}
}

namespace {
	require dirname(__DIR__) . "/src/utils/Utils.php";
	require dirname(__DIR__) . "/src/tasks/Installer.php";

	use pocketmine\utils\Internet;
	use thebigcrafter\APM\APM;
	use thebigcrafter\APM\TestServer;
	use thebigcrafter\APM\tasks\Installer;

	function expectInstaller(bool $condition, string $message): void {
		if (!$condition) {
			throw new RuntimeException($message);
		}
	}

	$root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "apm-installer-" . bin2hex(random_bytes(6)) . DIRECTORY_SEPARATOR;
	$pluginDirectory = $root . "plugins" . DIRECTORY_SEPARATOR;
	mkdir($pluginDirectory, 0777, true);
	APM::$instance = new APM(new TestServer($root));

	$firstBody = "plugin-v1";
	$secondBody = "plugin-v2";
	$firstUrl = "https://example.test/ExamplePlugin-v1.phar";
	$secondUrl = "https://example.test/ExamplePlugin-v2.phar";
	$catalog = static function (string $url, string $version, string $body): array {
		return [
			"name" => "Example Plugin",
			"version" => $version,
			"file" => $url,
			"md5" => md5($body),
			"sha1" => sha1($body),
			"sha256" => hash("sha256", $body),
			"sha512" => hash("sha512", $body),
		];
	};

	APM::$reposPluginsCache = [$catalog($firstUrl, "1.0.0", $firstBody)];
	Internet::$responses = [$firstUrl => new \pocketmine\utils\InternetResponseFixture(200, $firstBody)];
	expectInstaller(Installer::install("Example Plugin"), "A valid catalog entry should install");
	$installedPath = $pluginDirectory . "ExamplePlugin-v1.phar";
	expectInstaller(is_file($installedPath) && file_get_contents($installedPath) === $firstBody, "The verified first artifact should be written");
	expectInstaller(!Installer::install("Example Plugin"), "A normal install must not overwrite an existing plugin");

	APM::$reposPluginsCache = [$catalog($secondUrl, "2.0.0", $secondBody)];
	Internet::$responses = [$secondUrl => new \pocketmine\utils\InternetResponseFixture(200, $secondBody)];
	expectInstaller(Installer::install("Example Plugin", true), "An upgrade should replace the existing plugin after verification");
	$upgradedPath = $pluginDirectory . "ExamplePlugin-v2.phar";
	expectInstaller(is_file($upgradedPath) && file_get_contents($upgradedPath) === $secondBody, "The verified upgrade artifact should be written");

	$badUrl = "https://example.test/ExamplePlugin-bad.phar";
	APM::$reposPluginsCache = [$catalog($badUrl, "3.0.0", "different")];
	Internet::$responses = [$badUrl => new \pocketmine\utils\InternetResponseFixture(200, "tampered")];
	expectInstaller(!Installer::install("Example Plugin", true), "A hash mismatch must reject the artifact");
	expectInstaller(file_get_contents($upgradedPath) === $secondBody, "A rejected upgrade must preserve the current artifact");

	echo "AdvancedPluginManager installer and upgrade regression passed\n";
}
