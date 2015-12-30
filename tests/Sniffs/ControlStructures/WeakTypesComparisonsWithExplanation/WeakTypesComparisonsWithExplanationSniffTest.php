<?php

namespace Symplify\CodingStandard\Tests\Sniffs\ControlStructures\WeakTypesComparisonsWithExplanation;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;

/**
 * @covers SymplifyCodingStandard\Sniffs\ControlStructures\WeakTypesComparisonsWithExplanationSniff
 */
final class WeakTypesComparisonsWithExplanationSniffTest extends PHPUnit_Framework_TestCase
{
    public function testDetection()
    {
        $codeSnifferRunner = new CodeSnifferRunner(
            'SymplifyCodingStandard.ControlStructures.WeakTypesComparisonsWithExplanation'
        );

        $this->assertSame(2, $codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong.php.inc'));
        $this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__.'/correct.php.inc'));
    }
}
