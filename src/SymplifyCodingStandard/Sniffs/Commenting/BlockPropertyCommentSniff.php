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
 * - Block comment should be used instead of one liner.
 */
final class BlockPropertyCommentSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var array
     */
    private $tokens;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_DOC_COMMENT_OPEN_TAG];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $file, $position)
    {
        $this->file = $file;
        $this->tokens = $file->getTokens();

        $closeTagPosition = $file->findNext(T_DOC_COMMENT_CLOSE_TAG, $position + 1);
        if ($this->isPropertyOrMethodComment($closeTagPosition) === false) {
            return;
        } elseif ($this->isSingleLineDoc($position, $closeTagPosition) === false) {
            return;
        }

        $error = 'Block comment should be used instead of one liner';
        $file->addError($error, $position);
    }

    /**
     * @param int $position
     *
     * @return bool
     */
    private function isPropertyOrMethodComment($position)
    {
        $nextPropertyOrMethodPosition = $this->file->findNext([T_VARIABLE, T_FUNCTION], $position + 1);
        if ($this->isVariableOrPropertyUse($nextPropertyOrMethodPosition) === true) {
            return false;
        }

        return true;
    }

    /**
     * @param int $openTagPosition
     * @param int $closeTagPosition
     *
     * @return bool
     */
    private function isSingleLineDoc($openTagPosition, $closeTagPosition)
    {
        $lines = $this->tokens[$closeTagPosition]['line'] - $this->tokens[$openTagPosition]['line'];
        if ($lines < 2) {
            return true;
        }

        return false;
    }

    /**
     * @param int $position
     *
     * @return bool
     */
    private function isVariableOrPropertyUse($position)
    {
        if ($previous = $this->file->findPrevious(T_OPEN_CURLY_BRACKET, $position - 1)) {
            $previous = $this->file->findPrevious(T_OPEN_CURLY_BRACKET, $previous - 1);
            if ($this->tokens[$previous]['code'] === T_OPEN_CURLY_BRACKET) { // used in method
                return true;
            }
        }

        return false;
    }
}
