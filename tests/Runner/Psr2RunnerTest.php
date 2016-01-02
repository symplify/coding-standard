<?php

namespace Symplify\CodingStandard\Tests\Runner;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symplify\CodingStandard\Runner\Psr2Runner;

final class Psr2RunnerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RunnerInterface
     */
    private $runner;

    protected function setUp()
    {
        $this->runner = new Psr2Runner('inc');
    }

    public function testRunForDirectory()
    {
        $output = $this->runner->runForDirectory(__DIR__.'/Psr2RunnerSource');

        $this->assertStringMatchesFormat(
            file_get_contents(__DIR__.'/Psr2RunnerSource/expected.txt'),
            $output
        );
    }

    public function testHasErrors()
    {
        $this->assertFalse($this->runner->hasErrors());
        $this->runner->runForDirectory(__DIR__.'/Psr2RunnerSource');

        $this->assertTrue($this->runner->hasErrors());
    }

    public function testFixDirectory()
    {
        $this->runner->fixDirectory(__DIR__.'/Psr2RunnerSource');
    }
}
