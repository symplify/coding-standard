<?php

namespace Symplify\CodingStandard\Tests\Sniffs\Naming\AbstractClassName;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;

/**
 * @covers SymplifyCodingStandard\Sniffs\Naming\AbstractClassNameSniff
 */
final class AbstractClassNameSniffTest extends PHPUnit_Framework_TestCase
{
    public function testDetection()
    {
        $codeSnifferRunner = new CodeSnifferRunner('SymplifyCodingStandard.Naming.AbstractClassName');

        $this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__.'/correct.php.inc'));
        $this->assertSame(0, $codeSnifferRunner->getErrorCountInFile(__DIR__.'/correct2.php.inc'));
        $this->assertSame(1, $codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong.php.inc'));
    }
}
