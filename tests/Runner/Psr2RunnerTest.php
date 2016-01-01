<?php

namespace Symplify\CodingStandard\Tests\Runner;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Runner\Psr2Runner;

final class Psr2RunnerTest extends PHPUnit_Framework_TestCase
{
    public function testRunForDirectory()
    {
        $runner = new Psr2Runner('inc');
        $output = $runner->runForDirectory(__DIR__.'/Psr2RunnerSource');

        $this->assertStringMatchesFormat(
            file_get_contents(__DIR__.'/Psr2RunnerSource/expected.txt'),
            $output
        );
    }
}
