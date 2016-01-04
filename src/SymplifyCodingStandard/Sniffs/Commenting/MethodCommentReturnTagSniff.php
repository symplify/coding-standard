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
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

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
        $this->file = $file;
        $this->position = $position;

        $methodName = $file->getDeclarationName($position);
        if ($this->guessIsGetterMethod($methodName) === false) {
            return;
        }

        if ($this->hasMethodComment() === false) {
            $file->addError('Getters should have docblock.', $position);

            return;
        }

        if ($this->hasMethodCommentReturnOrInheritDoc()) {
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
     * @return string
     */
    private function getMethodComment()
    {
        if (!$this->hasMethodComment()) {
            return '';
        }

        $commentStart = $this->file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $this->position - 1);
        $commentEnd = $this->file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $this->position - 1);

        return $this->file->getTokensAsString($commentStart, $commentEnd - $commentStart + 1);
    }

    /**
     * @return bool
     */
    private function hasMethodCommentReturnOrInheritDoc()
    {
        $comment = $this->getMethodComment();

        if (strpos($comment, '{@inheritdoc}') !== false) {
            return true;
        }

        if (strpos($comment, '@return') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function hasMethodComment()
    {
        $tokens = $this->file->getTokens();
        $currentToken = $tokens[$this->position];
        $docBlockClosePosition = $this->file->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $this->position);

        if ($docBlockClosePosition === false) {
            return false;
        }

        $docBlockCloseToken = $tokens[$docBlockClosePosition];
        if ($docBlockCloseToken['line'] === ($currentToken['line'] - 1)) {
            return true;
        }

        return false;
    }
}
