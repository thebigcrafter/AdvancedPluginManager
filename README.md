[![PoggitCI](https://poggit.pmmp.io/ci.shield/thebigcrafter/AdvancedPluginManager/~)](https://github.com/thebigcrafter/AdvancedPluginManager)
[![PHPStan](https://github.com/thebigcrafter/AdvancedPluginManager/actions/workflows/phpstan-analysis.yml/badge.svg)](https://github.com/thebigcrafter/AdvancedPluginManager/actions/workflows/phpstan-analysis.yml)
[![License](https://img.shields.io/github/license/thebigcrafter/AdvancedPluginManager)](https://github.com/thebigcrafter/AdvancedPluginManager/blob/main/LICENSE)
[![Discord](https://img.shields.io/badge/chat-on%20discord-blue)](https://discord.gg/pdUvA8nXJC)

# Advanced Plugin Manager

Advanced Plugin Manager (APM) is a powerful, open source plugin manager inspired by [APT](https://en.wikipedia.org/wiki/APT_(software)) (Advanced Package Tool) in Debian-based Linux distributions for PocketMine-MP and developed by thebigcrafter.

*For more information, please visit [wiki](https://github.com/thebigcrafter/AdvancedPluginManager/wiki).*

# Installation

1. Download the latest version from [here](https://github.com/thebigcrafter/AdvancedPluginManager/releases).
2. Move it to `plugins` folder.
3. Restart your server.

# Requirements

- Axolotl-PM with plugin API 5.0.0 or a compatible API 5 release.
- The plugin bundles its Composer virions in the distributed PHAR.

# Build and test

The build workflow installs the locked runtime dependencies, creates the plugin PHAR with the pinned DevTools build script, and verifies the PHAR contents before uploading the artifact. Local contributors can run `composer install` and `composer run analyse` before reviewing the workflow artifact.

# Contributing

Read our [contributing guide](https://github.com/thebigcrafter/AdvancedPluginManager/blob/main/CONTRIBUTING.md) to learn about reporting bugs, requesting features, and translating this plugin into another language.

# Code of Conduct

This project has adopted a Code of Conduct that we expect project participants to adhere to. Please read the full text [here](https://github.com/thebigcrafter/AdvancedPluginManager/blob/main/CODE_OF_CONDUCT.md).

# License

Released under the [GPL-3.0](https://github.com/thebigcrafter/AdvancedPluginManager/blob/main/LICENSE) license.
