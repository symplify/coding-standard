<?php

namespace Symplify\CodingStandard\Tests\Sniffs\Classes\ClassDeclaration;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymplifyCodingStandard\Sniffs\Classes\FinalInterfaceSniff
 */
final class FinalInterfaceSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymplifyCodingStandard.Classes.FinalInterface');

		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct2.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct3.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct4.php'));
	}

}
