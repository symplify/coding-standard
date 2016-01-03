<?php

namespace Symplify\CodingStandard\Tests\PhpCodeSniffer\Helper\Commenting;

use PHP_CodeSniffer_File;
use PHPUnit_Framework_TestCase;
use Symplify\CodingStandard\PhpCodeSniffer\Helper\Commenting\MethodDocBlock;

final class MethodDocBlockTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MethodDocBlock
     */
    private $methodDocBlock;

    protected function setUp()
    {
        $this->methodDocBlock = new MethodDocBlock();
    }

    public function testHasMethodDocBlock()
    {
        $file = $this->prophesize(PHP_CodeSniffer_File::class);
        $value = $this->methodDocBlock->hasMethodDocBlock($file->reveal(), 1);
        $this->assertFalse($value);
    }
}
