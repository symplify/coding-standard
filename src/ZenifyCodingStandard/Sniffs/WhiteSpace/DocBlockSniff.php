<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\WhiteSpace;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - DocBlock lines should start with space (except first one)
 */
final class DocBlockSniff implements PHP_CodeSniffer_Sniff
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
	 * @var array[]
	 */
	private $tokens;


	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_DOC_COMMENT_STAR, T_DOC_COMMENT_CLOSE_TAG];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;
		$this->tokens = $file->getTokens();

		if ($this->isInlineComment()) {
			return;
		}

		if ( ! $this->isIndentationInFrontCorrect()) {
			$file->addError('DocBlock lines should start with space (except first one)', $position);
		}

		if ( ! $this->isIndentationInsideCorrect()) {
			$file->addError('Indentation in DocBlock should be one space followed by tabs (if necessary)', $position);
		}
	}


	/**
	 * @return bool
	 */
	private function isInlineComment()
	{
		if ($this->tokens[$this->position - 1]['code'] !== T_DOC_COMMENT_WHITESPACE) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isIndentationInFrontCorrect()
	{
		$tokens = $this->file->getTokens();
		if ($tokens[$this->position - 1]['content'] === ' ') {
			return TRUE;
		}
		if ((strlen($tokens[$this->position - 1]['content']) % 2) === 0) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isIndentationInsideCorrect()
	{
		$tokens = $this->file->getTokens();
		if ($tokens[$this->position + 1]['code'] === 'PHPCS_T_DOC_COMMENT_WHITESPACE') {
			$content = $tokens[$this->position + 1]['content'];
			$content = rtrim($content, "\n");
			if ( strlen($content) > 1
				&& $content !== ' ' . str_repeat("\t", strlen($content) - 1)
			) {
				return FALSE;
			}
		}
		return TRUE;
	}

}
