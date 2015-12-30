<?php

namespace Symplify\CodingStandard\Tests\Sniffs\Namespaces\ClassNamesWithoutPreSlash;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymplifyCodingStandard\Sniffs\Namespaces\ClassNamesWithoutPreSlashSniff
 */
final class ClassNamesWithoutPreSlashSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymplifyCodingStandard.Namespaces.ClassNamesWithoutPreSlash');

		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
	}

}
