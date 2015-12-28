<?php

namespace Symotion\CodingStandard\Tests\Sniffs\ControlStructures\WeakTypesComparisonsWithExplanation;

use PHPUnit_Framework_TestCase;
use Symotion\CodingStandard\Tests\CodeSnifferRunner;


/**
 * @covers SymotionCodingStandard\Sniffs\ControlStructures\WeakTypesComparisonsWithExplanationSniff
 */
final class WeakTypesComparisonsWithExplanationSniffTest extends PHPUnit_Framework_TestCase
{

	public function testDetection()
	{
		$codeSnifferRunner = new CodeSnifferRunner(
				'SymotionCodingStandard.ControlStructures.WeakTypesComparisonsWithExplanation'
		);
		$this->assertSame(2, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/wrong.php'));
		$this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__ . '/correct.php'));
	}

}
