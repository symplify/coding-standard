<?php

namespace Symplify\CodingStandard\Tests\Console;

use PHPUnit_Framework_Assert;
use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Command\CheckCommand;
use Symplify\CodingStandard\Command\FixCommand;
use Symplify\CodingStandard\Console\Application;
use Symplify\CodingStandard\Contract\Runner\RunnerCollectionInterface;

final class ApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $application;

    protected function setUp()
    {
        $this->application = new Application();
    }

    public function testDefaultCommands()
    {
        $this->assertInstanceOf(CheckCommand::class, $this->application->find('check'));
        $this->assertInstanceOf(FixCommand::class, $this->application->find('fix'));
    }

    public function testRunnerCollection()
    {
        $checkCommand =  $this->application->find('check');

        /** @var RunnerCollectionInterface $runnerCollection */
        $runnerCollection = PHPUnit_Framework_Assert::getObjectAttribute($checkCommand, 'runnerCollection');

        $this->assertInstanceOf(RunnerCollectionInterface::class, $runnerCollection);
        $this->assertCount(3, $runnerCollection->getRunners());
    }
}
