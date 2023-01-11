<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\TokenRunner\ValueObject;

final class LineLengthAndPosition
{
    public function __construct(
        private readonly int $lineLength,
        private readonly int $currentPosition
    ) {
    }

    public function getLineLength(): int
    {
        return $this->lineLength;
    }

    public function getCurrentPosition(): int
    {
        return $this->currentPosition;
    }
}
