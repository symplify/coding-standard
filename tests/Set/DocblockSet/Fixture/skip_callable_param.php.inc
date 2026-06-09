<?php

use Symplify\CodingStandard\Tests\Set\DocblockSet\Source\Schedule;

final class SkipCallableParam
{
    /**
     * @param callable(int $stepCount): void $postFileCallback
     */
    public function findFirst(
        Schedule $schedule,
        callable $postFileCallback
    ) {
    }
}
