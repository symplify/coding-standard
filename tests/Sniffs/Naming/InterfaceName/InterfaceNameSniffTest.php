<?php

namespace Symplify\CodingStandard\Tests\Sniffs\Naming\InterfaceName;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Tests\CodeSnifferRunner;

/**
 * @covers SymplifyCodingStandard\Sniffs\Naming\InterfaceNameSniff
 */
final class InterfaceNameSniffTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CodeSnifferRunner
     */
    private $codeSnifferRunner;

    protected function setUp()
    {
        $this->codeSnifferRunner = new CodeSnifferRunner('SymplifyCodingStandard.Naming.InterfaceName');
    }

    public function testDetection()
    {
        $this->assertSame(0, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/correct.php.inc'));
        $this->assertSame(0, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/correct2.php.inc'));
        $this->assertSame(1, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong.php.inc'));
        $this->assertSame(1, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong2.php.inc'));
        $this->assertSame(1, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong3.php.inc'));
        $this->assertSame(1, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong4.php.inc'));
        $this->assertSame(1, $this->codeSnifferRunner->getErrorCountInFile(__DIR__.'/wrong5.php.inc'));
    }

    public function testFixing()
    {
        $fixedContent = $this->codeSnifferRunner->getFixedContent(__DIR__.'/wrong.php.inc');
        $this->assertSame(file_get_contents(__DIR__.'/wrong.fixed.php.inc'), $fixedContent);
    }
}
