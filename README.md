# Coding Standard

[![Build Status](https://img.shields.io/travis/Symplify/CodingStandard.svg?style=flat-square)](https://travis-ci.org/Symplify/CodingStandard)
[![Quality Score](https://img.shields.io/scrutinizer/g/Symplify/CodingStandard.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/CodingStandard)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Symplify/CodingStandard.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symplify/CodingStandard)
[![Downloads](https://img.shields.io/packagist/dt/symplify/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symplify/coding-standard)
[![Latest stable](https://img.shields.io/packagist/v/symplify/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symplify/coding-standard)

Set of rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) based on [PSR-2](http://www.php-fig.org/psr/psr-2/) and [Symfony coding standard](http://symfony.com/doc/current/contributing/code/standards.html).

**Check [rules overview](docs/en/rules-overview.md) for examples.**


## Install

```sh
$ composer require symplify/coding-standard --dev
```

## Usage

If you want to check your `/src` directory, just run these 3 commands:

```sh
$ vendor/bin/phpcs src --standard=vendor/symplify/coding-standard/src/SymplifyCodingStandard/ruleset.xml -p -s --colors
$ vendor/bin/phpcs src --standard=PSR2 -p -s --colors
$ vendor/bin/php-cs-fixer fix src --dry-run --diff -v --level=symfony
```

or you can make use of bin file:

```sh
$ vendor/bin/symplify-cs check src
```

This command accepts multiple dirs as well.

```sh
$ vendor/bin/symplify-cs check src tests
```

## Fixing with ease

You can either fix code with low level tools, like:

```sh
$ vendor/bin/phpcbf src --standard=vendor/symplify/coding-standard/src/SymplifyCodingStandard/ruleset.xml --colors
$ vendor/bin/phpcbf src --standard=PSR2 --colors
$ vendor/bin/php-cs-fixer fix src --diff -v --level=symfony
```

or again use bin file:

```sh
$ vendor/bin/symplify-cs fix src
```

That's all!


## PhpStorm Integration

If you use PhpStorm, code sniffer can check your syntax as you write. [How to integrate?](docs/en/integration-to-php-storm.md)


## How to be both Lazy and Safe

### Composer hook

In case you don't want to use Php_CodeSniffer manually for every change in the code you make, you can add pre-commit hook via `composer.json`:

```json
"scripts": {
	"post-install-cmd": [
		"Symplify\\CodingStandard\\Composer\\ScriptHandler::addPhpCsToPreCommitHook"
	],
	"post-update-cmd": [
		"Symplify\\CodingStandard\\Composer\\ScriptHandler::addPhpCsToPreCommitHook"
	]
}
```

**Every time you try to commit, Php_CodeSniffer will run on changed `.php` files only.**

This is much faster than checking whole project, running manually or wait for CI.

*Pretty cool, huh?*
