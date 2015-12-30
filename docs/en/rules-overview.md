# Symotion Rules Overview

Rules uses default numeric parameters (some can be changed to match your needs).

**TOC:**

- [1 Classes](#1-classes)
- [2 Commenting](#2-commenting)
- [3 Control Structures](#3-control-structures) 
- [4 Debug](#4-debug) 
- [5 Namespaces](#5-namespaces) 
- [6 Naming](#6-naming) 

---

## 1 Classes

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


## 2 Commenting


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


## 3 Control Structures


### NewClassSniff
 
- New class statement should not have empty parentheses

*Correct*

```php
$someClass = new SomeNamespace\SomeClass;
$someClass = new SomeNamespace\SomeClass($keyHandler);
```

*Wrong*

```php
$someClass = new SomeNamespace\SomeClass();
```

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


## 4 Debug


### DebugFunctionCallSniff

- Debug functions should not be left in the code

*Wrong*

```php
dump('It works');
```


## 5 Namespaces


### NamespaceDeclarationSniff

- There must be 2 empty lines after the namespace declaration or 1 empty line followed by use statement.

*Correct*

```php
namespace SomeNamespace;

use PHP_CodeSniffer;


class SomeClass
{

}
```

or

```php
namespace SomeNamespace;


class SomeClass
{

}
```

*Wrong*

```php
namespace SomeNamespace;


use SomeNamespace;


class SomeClass
{

}
```

or

```php
namespace SomeNamespace;

class SomeClass
{

}
```


### UseDeclarationSniff 

- There must be one USE keyword per declaration
- There must be 2 blank lines after the last USE statement

*Correct*

```php
namespace SomeNamespace;

use Sth;
use SthElse;


class SomeClass
{

}
```

*Wrong*

```php
namespace SomeNamespace;

use Sth, SthElse;

class SomeClass
{

}
```


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


## 6 Naming


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
