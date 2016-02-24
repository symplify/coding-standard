<?php

namespace Symplify\CodingStandard\Tests\Runner\RunnerCollectionSource;

use Symplify\CodingStandard\Contract\Runner\RunnerInterface;

final class RandomRunner implements RunnerInterface
{
    /**
     * {@inheritdoc}
     */
    public function runForDirectory($directory)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function fixDirectory($directory)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function hasErrors()
    {
    }
}
