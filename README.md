# Laravel Artisan Anywhere

[![pipeline status](https://gitlab.com/two-thirds/artisan-anywhere/badges/master/pipeline.svg)](https://gitlab.com/two-thirds/artisan-anywhere/commits/master)
[![coverage report](https://gitlab.com/two-thirds/artisan-anywhere/badges/master/coverage.svg)](https://gitlab.com/two-thirds/artisan-anywhere/commits/master)

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

    composer require --dev two-thirds/artisan-anywhere

<a id="create-artisan-file"></a>
## Create Artisan File

Add an `artisan` file to the root of your project with the following content and add your commands to the `registerCommands` array:

```
#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

$artisan = new TwoThirds\ArtisanAnywhere\Artisan(__DIR__);

$artisan->registerCommands([
    Illuminate\Foundation\Console\TestMakeCommand::class,
]);

exit($artisan->handle());
```
