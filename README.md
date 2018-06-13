# Laravel Artisan Anywhere

Add Laravel Artisan to anything! Simply require through composer, drop a file in the root of your project and register any commands that you want available. This is a simple way to add custom utility commands ( like CI or stubbing content ) to non-Laravel projects ( like packages or other frameworks ).

<!-- MarkdownTOC autolink="true" autoanchor="true" bracket="round" -->

- [Installation](#installation)
	- [Composer](#composer)
	- [Create Artisan File](#create-artisan-file)

<!-- /MarkdownTOC -->

<a id="installation"></a>
# Installation

<a id="composer"></a>
## Composer

Laravel Artisan Anywhere can be installed through composer:

    composer require two-thirds/artisan-anywhere

<a id="create-artisan-file"></a>
## Create Artisan File

Add an `artisan` file to the root of your project with the following content and add your commands to the `registerCommands` array:

```
#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

$artisan = new TwoThirds\ArtisanAnywhere\Artisan;

$artisan->registerCommands([
    Illuminate\Foundation\Console\TestMakeCommand::class,
]);

exit($artisan->handle());
```
