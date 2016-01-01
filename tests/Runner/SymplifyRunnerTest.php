<?php

namespace Symplify\CodingStandard\Tests\Runner;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Runner\SymplifyRunner;

final class SymplifyRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testRunForDirectory()
    {
        $runner = new SymplifyRunner('inc');
        $output = $runner->runForDirectory(__DIR__.'/SymplifyRunnerSource');

        $this->assertStringMatchesFormat(
            file_get_contents(__DIR__.'/SymplifyRunnerSource/expected.txt'),
            $output
        );
    }
}
