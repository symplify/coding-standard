<?php

namespace Symotion\CodingStandard\Tests\Sniffs\WhiteSpace\IfElseTryCatchFinally;

use PHPUnit_Framework_TestCase;
use Symotion\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymotionCodingStandard\Sniffs\WhiteSpace\IfElseTryCatchFinallySniff
 */
final class IfElseTryCatchFinallySniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymotionCodingStandard.WhiteSpace.IfElseTryCatchFinally');

		$this->assertSame(3, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
	}

}
