<?php

namespace Symplify\CodingStandard\Tests;

use PHP_CodeSniffer;
use Symplify\CodingStandard\Tests\Exception\FileNotFoundException;

final class CodeSnifferRunner
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    /**
     * @param string $sniff
     */
    public function __construct($sniff)
    {
        $this->codeSniffer = new PHP_CodeSniffer();
        $this->codeSniffer->initStandard(__DIR__.'/../src/SymplifyCodingStandard/ruleset.xml', [$sniff]);
    }

    /**
     * @param string $source
     *
     * @return int
     */
    public function getErrorCountInFile($source)
    {
        $this->ensureFileExists($source);

        $file = $this->codeSniffer->processFile($source);

        return $file->getErrorCount();
    }

    /**
     * @param string $source
     */
    private function ensureFileExists($source)
    {
        if (!file_exists($source)) {
            throw new FileNotFoundException(
                sprintf('File "%s" was not found.', $source)
            );
        }
    }
}
