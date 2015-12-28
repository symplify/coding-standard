<?php

namespace SymotionTests\MikulasCodeSniffs\Sniffs\Namespaces\UseInAlphabeticalOrder;

use PHPUnit_Framework_TestCase;
use Symotion\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymotionCodingStandard\Sniffs\Namespaces\UseInAlphabeticalOrderSniff
 */
final class UseInAlphabeticalOrderSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymotionCodingStandard.Namespaces.UseInAlphabeticalOrder');

		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong2.php'));
		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong3.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct2.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct3.php'));
	}

}
