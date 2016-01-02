<?php

namespace Symplify\CodingStandard\Tests\Runner;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Contract\Runner\RunnerInterface;
use Symplify\CodingStandard\Runner\RunnerCollection;
use Symplify\CodingStandard\Tests\Runner\RunnerCollectionSource\RandomRunner;

final class RunnerCollectionTest extends PHPUnit_Framework_TestCase
{
    public function testRunForDirectory()
    {
        $runnerCollection = new RunnerCollection();
        $this->assertSame([], $runnerCollection->getRunners());

        $runnerCollection->addRunner(new RandomRunner());

        $runners = $runnerCollection->getRunners();
        $this->assertInstanceOf(RunnerInterface::class, $runners[0]);
    }
}
