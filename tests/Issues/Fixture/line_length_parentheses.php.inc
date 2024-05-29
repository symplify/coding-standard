<?php declare(strict_types=1);

final class LineLengtParentheses
{
    public function __construct(
        private DateTimeImmutable $dateTimeImmutable = new DateTimeImmutable()
    ) {}
}

?>
-----
<?php declare(strict_types=1);

final class LineLengtParentheses
{
    public function __construct(
        private DateTimeImmutable $dateTimeImmutable = new DateTimeImmutable
    ) {}
}

?>
