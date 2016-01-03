# Symplify Rules Overview

## FinalInterfaceSniff (Class)

- Non-abstract class that implements interface should be final.
- Except for Doctrine entities, they cannot be final.

```php
final class SomeClass implements SomeInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function run()
	{

	}
}
```


## BlockPropertyCommentSniff (Commenting)

- Block comment should be used instead of one liner

```php
class SomeClass
{
	/**
	 * @var int
	 */
	public $count;
}
```


## VarPropertyCommentSniff (Commenting)

- Property should have docblock comment (except for {@inheritdoc}).
 
```php
class SomeClass
{
	/**
	 * @var int
	 */
	private $someProperty;
}
```

## MethodCommentSniff (Commenting)

- Method without parameter typehints should have docblock comment.

```php
class SomeClass
{
	/**
	 * @param int $values
	 */
	public function count($values)
	{
	}

    public function count(array $values)
    {
    }
}
```

## MethodCommentReturnTagSniff (Commenting)

- Getters should have @return tag (except for {@inheritdoc}).

```php
class SomeClass
{
	/**
	 * @return int
	 */
	public function getResult()
	{
		// ...
	}
}
```


## WeakTypeComparisonWithExplanationSniff (Control Structures)

- Strong comparison should be used instead of weak one, or commented with its purpose

```php
if ($i == true) { // intentionally ==, failure proof
	return;
}

if ($i !== true) {
	return;
}
```


## DebugFunctionCallSniff (Debug)

- Debug functions should not be left in the code


## ClassNamesWithoutPreSlashSniff (Namespaces)

- Class name after new/instanceof should not start with slash

```php
use Some\File;

$file = new File;
```


## AbstractClassNameSniff (Naming)

- Abstract class should have prefix "Abstract"


## InterfaceNameSniff (Naming)

- Interface should have suffix "Interface"
