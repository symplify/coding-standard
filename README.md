# Coding Standard

[![Downloads](https://img.shields.io/packagist/dt/symplify/coding-standard.svg?style=flat-square)](https://packagist.org/packages/symplify/coding-standard/stats)

> [!WARNING]
> **This package is deprecated.** Use [Easy Coding Standard (ECS)](https://github.com/easy-coding-standard/easy-coding-standard) instead, where these rules and coding standard work out of the box—no extra setup needed.

Coding standard rules for clean, consistent, and readable PHP code. No configuration needed—just install and let it handle the rest.

They run best with [ECS](https://github.com/symplify/easy-coding-standard).

<br>

## Install

```bash
composer require symplify/coding-standard symplify/easy-coding-standard --dev
```

1. Register in `ecs.php` config:

```php
 # ecs.php
 use Symplify\EasyCodingStandard\Config\ECSConfig;

 return ECSConfig::configure()
    ->withPreparedSets(symplify: true);
```


2. And run:

```bash
# dry-run without changes
vendor/bin/ecs


# apply changes
vendor/bin/ecs --fix
```

<br>

# 23 Rules to Keep Your Code Clean

## ArrayListItemNewlineFixer

Indexed PHP array item has to have one line per item

- class: [`Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer`](../src/Fixer/ArrayNotation/ArrayListItemNewlineFixer.php)

```diff
-$value = ['simple' => 1, 'easy' => 2];
+$value = ['simple' => 1,
+'easy' => 2];
```

<br>

## ArrayOpenerAndCloserNewlineFixer

Indexed PHP array opener [ and closer ] must be on own line

- class: [`Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer`](../src/Fixer/ArrayNotation/ArrayOpenerAndCloserNewlineFixer.php)

```diff
-$items = [1 => 'Hey'];
+$items = [
+1 => 'Hey'
+];
```

<br>

## BlankLineAfterStrictTypesFixer

Strict type declaration has to be followed by empty line

- class: [`Symplify\CodingStandard\Fixer\Strict\BlankLineAfterStrictTypesFixer`](../src/Fixer/Strict/BlankLineAfterStrictTypesFixer.php)

```diff
 declare(strict_types=1);
+
 namespace App;
```

<br>

## LineLengthFixer

Array items, method parameters, method call arguments, new arguments should be on same/standalone line to fit line length.

:wrench: **configure it!**

- class: [`Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer`](../src/Fixer/LineLength/LineLengthFixer.php)

```diff
-function some($veryLong, $superLong, $oneMoreTime)
-{
+function some(
+    $veryLong,
+    $superLong,
+    $oneMoreTime
+) {
 }

-function another(
-    $short,
-    $now
-) {
+function another($short, $now) {
 }
```

<br>

## MethodChainingNewlineFixer

Each chain method call must be on own line

- class: [`Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer`](../src/Fixer/Spacing/MethodChainingNewlineFixer.php)

```diff
-$someClass->firstCall()->secondCall();
+$someClass->firstCall()
+->secondCall();
```

<br>

## Doc block malform rules

Single-task rules that each fix one kind of `@param`/`@return`/`@var` malform. They are registered together in the [`docblock` set](../config/sets/docblock.php) and all handle the `@phpstan-` and `@psalm-` prefixed variants of these tags.

<br>

## AddMissingParamNameFixer

Add a missing variable name to a `@param` annotation

- class: [`Symplify\CodingStandard\Fixer\Commenting\AddMissingParamNameFixer`](../src/Fixer/Commenting/AddMissingParamNameFixer.php)

```diff
 /**
- * @param string
+ * @param string $name
  */
 function getPerson($name)
 {
 }
```

<br>

## AddMissingVarNameFixer

Add a missing variable name to an inline `@var` annotation

- class: [`Symplify\CodingStandard\Fixer\Commenting\AddMissingVarNameFixer`](../src/Fixer/Commenting/AddMissingVarNameFixer.php)

```diff
-/** @var int */
+/** @var int $value */
 $value = 1000;
```

<br>

## DoubleAsteriskInlineVarFixer

Use a double asterisk `/**` doc block for an inline `@var` comment

- class: [`Symplify\CodingStandard\Fixer\Commenting\DoubleAsteriskInlineVarFixer`](../src/Fixer/Commenting/DoubleAsteriskInlineVarFixer.php)

```diff
-/* @var int $variable */
+/** @var int $variable */
 $variable = 5;
```

<br>

## FixParamNameTypoFixer

Fix a typo in the `@param` variable name to match the real argument

- class: [`Symplify\CodingStandard\Fixer\Commenting\FixParamNameTypoFixer`](../src/Fixer/Commenting/FixParamNameTypoFixer.php)

```diff
 /**
  * @param string $one
- * @param string $twoTypo
+ * @param string $two
  */
 function anotherFunction(string $one, string $two)
 {
 }
```

<br>

## RemoveDeadParamFixer

Remove a dead `@param` line that has only a name and no type

- class: [`Symplify\CodingStandard\Fixer\Commenting\RemoveDeadParamFixer`](../src/Fixer/Commenting/RemoveDeadParamFixer.php)

```diff
 /**
  * @param string $name
- * @param $age
  */
 function withDeadParam(string $name, $age)
 {
 }
```

<br>

## RemoveParamNameReferenceFixer

Remove the reference `&` from a `@param` variable name

- class: [`Symplify\CodingStandard\Fixer\Commenting\RemoveParamNameReferenceFixer`](../src/Fixer/Commenting/RemoveParamNameReferenceFixer.php)

```diff
 /**
- * @param string &$name
+ * @param string $name
  */
 function paramReference($name)
 {
 }
```

<br>

## RemoveSuperfluousReturnNameFixer

Remove a superfluous variable name from a `@return` annotation

- class: [`Symplify\CodingStandard\Fixer\Commenting\RemoveSuperfluousReturnNameFixer`](../src/Fixer/Commenting/RemoveSuperfluousReturnNameFixer.php)

```diff
 /**
- * @return int $value
+ * @return int
  */
 function function1(): int
 {
 }
```

<br>

## RemoveSuperfluousVarNameFixer

Remove a superfluous variable name from a property `@var` annotation

- class: [`Symplify\CodingStandard\Fixer\Commenting\RemoveSuperfluousVarNameFixer`](../src/Fixer/Commenting/RemoveSuperfluousVarNameFixer.php)

```diff
 /**
- * @var string $property
+ * @var string
  */
 private $property;
```

<br>

## SingleLineInlineVarDocBlockFixer

Collapse a multi-line inline `@var` doc block into a single line

- class: [`Symplify\CodingStandard\Fixer\Commenting\SingleLineInlineVarDocBlockFixer`](../src/Fixer/Commenting/SingleLineInlineVarDocBlockFixer.php)

```diff
-/**
- * @var int $value
- */
+/** @var int $value */
 $value = 1000;
```

<br>

## SwitchedTypeAndNameFixer

Reorder switched type and variable name in `@param`/`@var` annotation

- class: [`Symplify\CodingStandard\Fixer\Commenting\SwitchedTypeAndNameFixer`](../src/Fixer/Commenting/SwitchedTypeAndNameFixer.php)

```diff
 /**
- * @param $a string
- * @param $b string|null
+ * @param string $a
+ * @param string|null $b
  */
 function test($a, string $b = null): string
 {
 }
```

<br>

## RemovePropertyVariableNameDescriptionFixer

Remove docblock descriptions which duplicate their property name

- class: [`Symplify\CodingStandard\Fixer\Annotation\RemovePropertyVariableNameDescriptionFixer`](../src/Fixer/Annotation/RemovePropertyVariableNameDescriptionFixer.php)

```diff
 /**
- * @var string $name
+ * @var string
  */
 private $name;
```

<br>

## RemoveMethodNameDuplicateDescriptionFixer

Remove docblock descriptions which duplicate their method name

- class: [`Symplify\CodingStandard\Fixer\Annotation\RemoveMethodNameDuplicateDescriptionFixer`](../src/Fixer/Annotation/RemoveMethodNameDuplicateDescriptionFixer.php)

```diff
 /**
- * Get name
  *
  * @return string
  */
 function getName()
 {
 }
```

<br>

## RemovePHPStormAnnotationFixer

Remove "Created by PhpStorm" annotations

- class: [`Symplify\CodingStandard\Fixer\Annotation\RemovePHPStormAnnotationFixer`](../src/Fixer/Annotation/RemovePHPStormAnnotationFixer.php)

```diff
-/**
- * Created by PhpStorm.
- * User: ...
- * Date: 17/10/17
- * Time: 8:50 AM
- */
 class SomeClass
 {
 }
```

<br>

## RemoveUselessDefaultCommentFixer

Remove useless PHPStorm-generated `@todo` comments, redundant "Class XY" or "gets service" comments etc.

- class: [`Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer`](../src/Fixer/Commenting/RemoveUselessDefaultCommentFixer.php)

```diff
-/**
- * class SomeClass
- */
 class SomeClass
 {
-    /**
-     * SomeClass Constructor.
-     */
     public function __construct()
     {
-        // TODO: Change the autogenerated stub
-        // TODO: Implement whatever() method.
     }
 }
```

It also removes "Class representing XY" comments:

```diff
-/**
- * Class representing TeamPlayer
- */
 class TeamPlayer
 {
 }
```

Comments that only repeat the class name are removed:

```diff
-/**
- * TeamPlayer
- */
 class TeamPlayer
 {
 }
```

As well as the default doc block generated by the Doctrine ORM:

```diff
-/**
- * This class was generated by the Doctrine ORM. Add your own custom
- * repository methods below.
- */
 class SomeRepository
 {
 }
```

<br>

## SpaceAfterCommaHereNowDocFixer

Add space after nowdoc and heredoc keyword, to prevent bugs on PHP 7.2 and lower, see https://laravel-news.com/flexible-heredoc-and-nowdoc-coming-to-php-7-3

- class: [`Symplify\CodingStandard\Fixer\Spacing\SpaceAfterCommaHereNowDocFixer`](../src/Fixer/Spacing/SpaceAfterCommaHereNowDocFixer.php)

```diff
 $values = [
     <<<RECTIFY
 Some content
-RECTIFY,
+RECTIFY
+,
     1000
 ];
```

<br>

## StandaloneLineConstructorParamFixer

Constructor param should be on a standalone line to ease git diffs on new dependency

- class: [`Symplify\CodingStandard\Fixer\Spacing\StandaloneLineConstructorParamFixer`](../src/Fixer/Spacing/StandaloneLineConstructorParamFixer.php)

```diff
 final class PromotedProperties
 {
-    public function __construct(int $age, string $name)
-    {
+    public function __construct(
+        int $age,
+        string $name
+    ) {
     }
 }
```

<br>

## StandaloneLineInMultilineArrayFixer

Indexed arrays must have 1 item per line

- class: [`Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer`](../src/Fixer/ArrayNotation/StandaloneLineInMultilineArrayFixer.php)

```diff
-$friends = [1 => 'Peter', 2 => 'Paul'];
+$friends = [
+    1 => 'Peter',
+    2 => 'Paul'
+];
```

<br>

## StandaloneLinePromotedPropertyFixer

Promoted property should be on standalone line

- class: [`Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer`](../src/Fixer/Spacing/StandaloneLinePromotedPropertyFixer.php)

```diff
 final class PromotedProperties
 {
-    public function __construct(public int $age, private string $name)
-    {
+    public function __construct(
+        public int $age,
+        private string $name
+    ) {
     }
 }
```

<br>
