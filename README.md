# Advanced Plugin Manager

Advanced Plugin Manager, or APM, manages PocketMine-MP plugin repositories from
the server console or an in-game form. It caches repository metadata, lists
available plugins, and downloads, updates or removes plugin files.

[![PHPStan](https://github.com/thebigcrafter/AdvancedPluginManager/actions/workflows/phpstan-analysis.yml/badge.svg)](https://github.com/thebigcrafter/AdvancedPluginManager/actions/workflows/phpstan-analysis.yml)
[![Latest release](https://img.shields.io/github/v/release/thebigcrafter/AdvancedPluginManager)](https://github.com/thebigcrafter/AdvancedPluginManager/releases/latest)
[![License](https://img.shields.io/github/license/thebigcrafter/AdvancedPluginManager)](LICENSE)

## Requirements

- PocketMine-MP or Axolotl-PM API `5.0.0` or a compatible API 5 release.
- A server with permission to write to its `plugins/` directory.
- Internet access from the server when refreshing repositories or downloading a plugin.

The distributed PHAR contains its Composer dependencies. APM does not require a
separate virion or plugin manager library in the server's `plugins/` directory.

## Installation

1. Download `AdvancedPluginManager.phar` from [GitHub Releases](https://github.com/thebigcrafter/AdvancedPluginManager/releases).
2. Copy it to the server's `plugins/` directory.
3. Restart the server.
4. Review `plugin_data/AdvancedPluginManager/config.yml` and the generated
   `repos.yml` before installing plugins.

APM starts with the repository `https://thebigcrafter.github.io/`. A repository
must expose the catalog format expected by APM, including plugin metadata and a
downloadable `file` URL. Only add repositories that you trust.

## Commands

All commands require `apm.cmd`, which defaults to operators. Running `/apm` as a
player opens the main form. Console commands use the same repository and plugin
caches.

| Command | Purpose |
| --- | --- |
| `/apm` | Open the management form for a player or show usage in console |
| `/apm add-repo <url>` | Add a repository URL |
| `/apm remove-repo <url>` | Remove a repository URL |
| `/apm list-repo` | List configured repositories |
| `/apm update` | Refresh repository metadata and plugin catalogs |
| `/apm install <plugin name>` | Install a plugin from the cached catalogs |
| `/apm remove <plugin name>` | Remove a plugin file by plugin name |
| `/apm list` | List plugins in the cached catalogs |

The player forms provide the same actions with selection controls. Installation
and removal operate on server files, so use the console form or command only for
operators who are trusted to change the server installation.

## Configuration

The default `config.yml` contains the language setting:

```yaml
language: eng
```

APM also creates `repos.yml` with the configured repository list:

```yaml
repositories:
  - https://thebigcrafter.github.io/
```

Language resources currently include English, Vietnamese, Indonesian, Russian
and Ukrainian. Repository data and plugin catalogs are cached asynchronously on
startup and after `/apm update`.

## Repository and safety notes

APM downloads files declared by the selected repository. It does not turn an
untrusted catalog into a trusted source. Review the repository owner, download
URL and plugin identity before installation.

Keep a server backup before removing or updating a plugin. Do not update a
plugin while the server is using it unless the plugin's own documentation says
that hot replacement is supported. A restart is normally required before a new
or updated PHAR is loaded.

## Build and verification

The build workflow installs locked dependencies, prepares the DevTools virions,
builds the PHAR and validates its contents and build metadata. PHPStan is not
currently enabled by the reusable build workflow, but the repository provides
an analysis script for local checks.

```sh
composer install
composer analyse
composer test:utils
composer test:installer
composer test:cache
```

The workflow artifact is a test result. Use a published GitHub Release for a
stable installation and read its release notes before upgrading a live server.

## License

Advanced Plugin Manager is released under the GPL-3.0 license. See [LICENSE](LICENSE)
for the complete text. Contributions should follow [CONTRIBUTING.md](CONTRIBUTING.md)
and the repository's [Code of Conduct](CODE_OF_CONDUCT.md).
