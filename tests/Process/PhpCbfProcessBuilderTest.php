<?php

namespace Symplify\CodingStandard\Tests\Process;

use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\Process\PhpCbfProcessBuilder;

final class PhpCbfProcessBuilderTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $builder = new PhpCbfProcessBuilder('directory');
        $this->assertSame(
            "'./vendor/bin/phpcbf' 'directory'",
            $builder->getProcess()->getCommandLine()
        );

        $builder->setExtensions('php5');
        $this->assertSame(
            "'./vendor/bin/phpcbf' 'directory' '--extensions=php5'",
            $builder->getProcess()->getCommandLine()
        );

        $builder->setStandard('standard');
        $this->assertSame(
            "'./vendor/bin/phpcbf' 'directory' '--extensions=php5' '--standard=standard'",
            $builder->getProcess()->getCommandLine()
        );
    }
}
