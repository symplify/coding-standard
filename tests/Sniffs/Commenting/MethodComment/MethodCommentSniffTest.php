<?php

namespace Symotion\CodingStandard\Tests\Sniffs\Commenting\MethodComment;

use PHPUnit_Framework_TestCase;
use Symotion\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymotionCodingStandard\Sniffs\Commenting\MethodCommentSniff
 */
final class MethodCommentSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymotionCodingStandard.Commenting.MethodComment');

		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct2.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct3.php'));
	}

}
