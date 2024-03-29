# Coding Standard

[![Downloads](https://img.shields.io/packagist/dt/symplify/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symplify/coding-standard/stats)

Set of rules for PHP_CodeSniffer and PHP-CS-Fixer used by Symplify projects.

**They run best with [EasyCodingStandard](https://github.com/symplify/easy-coding-standard)**.

## Install

```bash
composer require symplify/coding-standard --dev
composer require symplify/easy-coding-standard --dev
```

1. Run with [ECS](https://github.com/symplify/easy-coding-standard):

```diff
# ecs.php
 use Symplify\EasyCodingStandard\Config\ECSConfig;
+use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

 return static function (ECSConfig $ecsConfig): void {
+    $ecsConfig->sets([SetList::SYMPLIFY]);
```

## Rules Overview

- [Rules Overview](/docs/rules_overview.md)
