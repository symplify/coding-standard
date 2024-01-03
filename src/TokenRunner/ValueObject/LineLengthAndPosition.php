<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\TokenRunner\ValueObject;

final readonly class LineLengthAndPosition
{
    public function __construct(
        private int $lineLength,
        private int $currentPosition
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
