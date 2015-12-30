# Coding Standard

[![Build Status](https://img.shields.io/travis/Symotion/CodingStandard.svg?style=flat-square)](https://travis-ci.org/Symotion/CodingStandard)
[![Quality Score](https://img.shields.io/scrutinizer/g/Symotion/CodingStandard.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symotion/CodingStandard)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/Symotion/CodingStandard.svg?style=flat-square)](https://scrutinizer-ci.com/g/Symotion/CodingStandard)
[![Downloads](https://img.shields.io/packagist/dt/symotion/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symotion/coding-standard)
[![Latest stable](https://img.shields.io/packagist/v/symotion/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symotion/coding-standard)

Set of rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) based on [PSR-2](http://www.php-fig.org/psr/psr-2/) and [Symfony coding standard](http://symfony.com/doc/current/contributing/code/standards.html).

**Check [rules overview](docs/en/symotion-rules-overview.md) for examples.**


## Install

```sh
$ composer require symotion/coding-standard --dev
```

## Usage

Run with Php_CodeSniffer:

```sh
$ vendor/bin/phpcs src --standard=vendor/symotion/coding-standard/src/SymotionCodingStandard/ruleset.xml -p
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
		"Symotion\\CodingStandard\\Composer\\ScriptHandler::addPhpCsToPreCommitHook"
	],
	"post-update-cmd": [
		"Symotion\\CodingStandard\\Composer\\ScriptHandler::addPhpCsToPreCommitHook"
	]
}
```

**Every time you try to commit, Php_CodeSniffer will run on changed `.php` files only.**

This is much faster than checking whole project, running manually or wait for CI.

*Pretty cool, huh?*
