# Contributing to Advanced Plugin Manager

Welcome, and thank you for your interest in contributing to APM!

# Reporting Issues

Have a problem with APM or a feature request? We want to hear about it!

**NOTE:** Please check if the issue exists before creating.
 
If you cannot find an existing issue that describes your bug or feature, create a new issue using the guidelines below.

# Writing good bug reports and feature requests

To have a good bug reports and feature requests, please follow these guidelines:
- Only a single issue per issue and feature request.
- The more information you provide, the more likely it is that someone or us will succeed in recreating the problem and finding a fix.

Please include the following with each issue:
- Version of PocketMine
- Version of PHP
- Your OS
- What you expected to see, versus what you actually saw
- Steps to reproduce the issue
- Images, logs, or a link to a video showing the issue occurring

# Translate this plugin

Before translate this plugin, please add your language name to the `$languages` array in [`src/APM.php`](https://github.com/thebigcrafter/AdvancedPluginManager/blob/main/src/APM.php#L65)  
Copy the `resources/lang/eng.ini`, rename and translate it.  
**NOTE:** The language name must be the same as the language file name in `resources/lang/`.

For example:  
```php
private array $languages = ["eng"]; // => private array $languages = ["eng", "vie"];
```
And the `resources/lang` folder will have:
- eng.ini
- vie.ini

# Asking Questions

Please join our [Discord server](https://discord.gg/pdUvA8nXJC) to ask questions, get help, and discuss the project.

# Thank You!

Thank you for taking the time to contribute.
