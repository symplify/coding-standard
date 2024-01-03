<?php

declare(strict_types=1);

namespace Symplify\CodingStandard\Tests\Issues;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\EasyCodingStandard\Testing\PHPUnit\AbstractCheckerTestCase;

final class RemoveUselessDefaultCommentAndStatementIndentationFixerTest extends AbstractCheckerTestCase
{
    #[DataProvider('provideData')]
    public function test(string $filePath): void
    {
        $this->doTestFile($filePath);
    }

    public static function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/remove_useless_default_comment_and_statement_indentation.php.inc'];
    }

    public function provideConfig(): string
    {
        return __DIR__ . '/config/config_remove_useless_default_comment_and_statement_indentation.php';
    }
}
