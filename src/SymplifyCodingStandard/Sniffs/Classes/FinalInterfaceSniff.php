<?php

/**
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace SymplifyCodingStandard\Sniffs\Classes;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Rules:
 * - Non-abstract class that implements interface should be final.
 * - Except for Doctrine entities, they cannot be final.
 *
 * Inspiration:
 * - http://ocramius.github.io/blog/when-to-declare-classes-final/
 */
final class FinalInterfaceSniff implements PHP_CodeSniffer_Sniff
{
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
        return [T_CLASS];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $file, $position)
    {
        $this->file = $file;
        $this->position = $position;

        if ($this->implementsInterface() === false) {
            return;
        }

        if ($this->isFinalOrAbstractClass()) {
            return;
        }

        if ($this->isDoctrineEntity()) {
            return;
        }

        $file->addError(
            'Non-abstract class that implements interface should be final.',
            $position
        );
    }

    /**
     * @return bool
     */
    private function implementsInterface()
    {
        return (bool) $this->file->findNext(T_IMPLEMENTS, $this->position);
    }

    /**
     * @return bool
     */
    private function isFinalOrAbstractClass()
    {
        $classProperties = $this->file->getClassProperties($this->position);

        return $classProperties['is_abstract'] || $classProperties['is_final'];
    }

    /**
     * @return bool
     */
    private function isDoctrineEntity()
    {
        $docCommentPosition = $this->file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $this->position);
        if ($docCommentPosition === false) {
            return false;
        }

        $seekPosition = $docCommentPosition;

        do {
            $docCommentTokenContent = $this->file->getTokens()[$docCommentPosition]['content'];
            if (strpos($docCommentTokenContent, 'Entity') !== false) {
                return true;
            }
            ++$seekPosition;
        } while ($docCommentPosition = $this->file->findNext(T_DOC_COMMENT_TAG, $seekPosition, $this->position));

        return false;
    }
}
