<?php

namespace Symplify\CodingStandard\Tests\Runner;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Runner\SymfonyRunner;

final class SymfonyRunnerTest extends PHPUnit_Framework_TestCase
{
    public function testRunForDirectory()
    {
        $runner = new SymfonyRunner();
        $output = $runner->runForDirectory(__DIR__.'/SymfonyRunnerSource');

        $this->assertStringMatchesFormat(
            file_get_contents(__DIR__.'/SymfonyRunnerSource/expected.txt'),
            $output
        );
    }
}
