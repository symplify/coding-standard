<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace SymplifyCodingStandard\Sniffs\Commenting;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Rules:
 * - Getters should have @return tag (except for {@inheritdoc}).
 */
final class MethodCommentReturnTagSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string[]
     */
    private $getterMethodPrefixes = ['get', 'is', 'has', 'will', 'should'];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $file, $position)
    {
        $methodName = $file->getDeclarationName($position);
        $isGetterMethod = $this->guessIsGetterMethod($methodName);
        if ($isGetterMethod === false) {
            return;
        }

        if ($this->hasMethodDocBlock($file, $position) === false) {
            $file->addError('Getters should have docblock.', $position);

            return;
        }

        $commentString = $this->getMethodDocBlock($file, $position);

        if (strpos($commentString, '{@inheritdoc}') !== false) {
            return;
        }

        if (strpos($commentString, '@return') !== false) {
            return;
        }

        $file->addError('Getters should have @return tag (except {@inheritdoc}).', $position);
    }

    /**
     * @param string $methodName
     *
     * @return bool
     */
    private function guessIsGetterMethod($methodName)
    {
        foreach ($this->getterMethodPrefixes as $getterMethodPrefix) {
            if (strpos($methodName, $getterMethodPrefix) === 0) {
                if (strlen($methodName) === strlen($getterMethodPrefix)) {
                    return true;
                }

                $endPosition = strlen($getterMethodPrefix);
                $firstLetterAfterGetterPrefix = $methodName[$endPosition];

                if (ctype_upper($firstLetterAfterGetterPrefix)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int $position
     *
     * @return bool
     */
    private function hasMethodDocBlock(PHP_CodeSniffer_File $file, $position)
    {
        $tokens = $file->getTokens();
        $currentToken = $tokens[$position];
        $docBlockClosePosition = $file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $position);

        if ($docBlockClosePosition === false) {
            return false;
        }

        $docBlockCloseToken = $tokens[$docBlockClosePosition];
        if ($docBlockCloseToken['line'] === ($currentToken['line'] - 1)) {
            return true;
        }

        return false;
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int $position
     *
     * @return string
     */
    private function getMethodDocBlock(PHP_CodeSniffer_File $file, $position)
    {
        if (!$this->hasMethodDocBlock($file, $position)) {
            return '';
        }

        $commentStart = $file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $position - 1);
        $commentEnd = $file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $position - 1);

        return $file->getTokensAsString($commentStart, $commentEnd - $commentStart + 1);
    }
}
