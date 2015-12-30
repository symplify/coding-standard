# Symotion Rules Overview

Rules uses default numeric parameters (some can be changed to match your needs).

**TOC:**

- [Classes](#classes)
- [Commenting](#commenting)
- [Control Structures](#control-structures) 
- [Debug](#debug) 
- [Namespaces](#namespaces) 
- [Naming](#naming) 

---

## Classes

### FinalInterfaceSniff

- Non-abstract class that implements interface should be final.
- Except for Doctrine entities, they cannot be final.

*Correct*

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

*Wrong*

```php
class SomeClass implements SomeInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function run()
	{

	}

}
```


## Commenting


### BlockPropertyCommentSniff

- Block comment should be used instead of one liner

*Correct*

```php
class SomeClass
{

	/**
	 * @var int
	 */
	public $count;

}
```

*Wrong*

```php
class SomeClass
{

	/** @var int */
	public $count;

}
```



### VarPropertyCommentSniff

- Property should have docblock comment (except for {@inheritdoc}).
 
*Correct*

```php
class SomeClass
{

	/**
	 * @var int
	 */
	private $someProperty;

}
```

*Wrong*

```php
class SomeClass
{

	private $someProperty;

}
```


### MethodCommentSniff

- Method without parameter typehints should have docblock comment.

*Correct*

```php
class SomeClass
{

	/**
	 * @param int $values
	 */
	public function count($values)
	{
	}

}
```


```php
class SomeClass
{

	public function count(array $values)
	{
	}

}
```


*Wrong*

```php
class SomeClass
{

	public function count($values)
	{
	}

}
```


### MethodCommentReturnTagSniff

- Getters should have @return tag (except for {@inheritdoc}).

*Correct*

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


```php
class SomeClass
{

	/**
	 * {@inheritdoc}
	 */
	public function getResult()
	{
		// ...
	}

}
```


*Wrong*

```php
class SomeClass
{

	/**
	 * This will return something.
	 */
	public function getResult()
	{
	}

}
```


## Control Structures


### WeakTypeComparisonWithExplanationSniff

- Strong comparison should be used instead of weak one, or commented with its purpose

*Correct*

```php
if ($i == TRUE) { // intentionally ==, failure proof
	return;
}

if ($i !== TRUE) {
	return;
}
```

*Wrong*

```php
if ($i == TRUE) {
	return;
}
```


## Debug


### DebugFunctionCallSniff

- Debug functions should not be left in the code

*Wrong*

```php
dump('It works');
```


## Namespaces


### UseInAlphabeticalOrderSniff
 
-  Use statements should be in alphabetical order


*Correct*

```php
use A;
use B;
use C;
```


*Wrong*

```php
use C;
use A;
use B;
```


## Naming


### BoolSniff

- Bool operator should be spelled "bool"


*Correct*

```php
/** @var bool */
public $someProperty;
```

*Wrong*

```php
/** @var boolean */
public $someProperty;
```


### IntSniff

- Int operator should be spelled "int"


*Correct*

```php
/** @var int */
public $someProperty;
```

*Wrong*

```php
/** @var integer */
public $someProperty;
```


### AbstractClassNameSniff

- Abstract class should have prefix "Abstract"


*Correct*

```php
abstract class AbstractClass
{

}
```

*Wrong*

```php
abstract class SomeClass
{

}
```


### InterfaceNameSniff

- Interface should have suffix "Interface"


*Correct*

```php
interface SomeInterface
{

}
```

*Wrong*

```php
interface Some
{

}
```


### InheritDocSniff

- Inheritdoc comment should be spelled "{@inheritdoc}"


*Correct*

```php
class SomeClass
{

	/**
	 * {@inheritdoc}
	 */
	public function getSome()
	{
	}

}
```

*Wrong*

```php
class SomeClass
{

	/**
	 * @{inheritDoc}
	 */
	public function getSome()
	{
	}

}
```
