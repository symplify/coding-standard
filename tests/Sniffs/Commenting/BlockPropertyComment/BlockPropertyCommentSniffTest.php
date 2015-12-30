<?php

namespace Symplify\CodingStandard\Tests\Sniffs\Commenting\BlockPropertyComment;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymplifyCodingStandard\Sniffs\Commenting\BlockPropertyCommentSniff
 */
final class BlockPropertyCommentSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner('SymplifyCodingStandard.Commenting.BlockPropertyComment');

		$this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct2.php'));
	}

}
