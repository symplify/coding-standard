<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - Same as @see Squiz_Sniffs_ControlStructures_ControlSignatureSniff
 * - This modification allows comments
 */
final class ControlSignatureSniff implements PHP_CodeSniffer_Sniff
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
	 * @var array
	 */
	private $tokens;


	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_TRY, T_CATCH, T_DO, T_WHILE, T_FOR, T_IF, T_FOREACH, T_ELSE, T_ELSEIF];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;
		$this->tokens = $tokens = $file->getTokens();

		$this->ensureSingleSpaceAfterKeyword();
		$this->ensureSingleSpaceAfterClosingParenthesis();
		$this->ensureNewlineAfterOpeningBrace();

		// Only want to check multi-keyword structures from here on.
		if ($tokens[$position]['code'] === T_TRY || $tokens[$position]['code'] === T_DO) {
			$closer = $tokens[$position]['scope_closer'];

		} elseif ($tokens[$position]['code'] === T_ELSE || $tokens[$position]['code'] === T_ELSEIF) {
			$closer = $file->findPrevious(T_CLOSE_CURLY_BRACKET, ($position - 1));

		} else {
			return;
		}

		// Single space after closing brace.
		$found = 1;
		if ($tokens[($closer + 1)]['code'] !== T_WHITESPACE) {
			$found = 0;

		} else {
			if ($tokens[($closer + 1)]['content'] !== ' ') {
				if (strpos($tokens[($closer + 1)]['content'], $file->eolChar) !== FALSE) {
					$found = 'newline';

				} else {
					$found = strlen($tokens[($closer + 1)]['content']);
				}
			}
		}

		if ($found !== 1) {
			$error = 'Expected 1 space after closing brace; %s found';
			$data = [$found];
			$file->addError($error, $closer, 'SpaceAfterCloseBrace', $data);
		}
	}


	private function ensureSingleSpaceAfterKeyword()
	{
		$found = 1;
		if ($this->tokens[($this->position + 1)]['code'] !== T_WHITESPACE) {
			$found = 0;

		} elseif ($this->tokens[($this->position + 1)]['content'] !== ' ') {
			if (strpos($this->tokens[($this->position + 1)]['content'], $this->file->eolChar) !== FALSE) {
				$found = 'newline';

			} else {
				$found = strlen($this->tokens[($this->position + 1)]['content']);
			}
		}

		if ($found !== 1) {
			$error = 'Expected 1 space after %s keyword; %s found';
			$data = [
				strtoupper($this->tokens[$this->position]['content']),
				$found,
			];
			$this->file->addError($error, $this->position, 'SpaceAfterKeyword', $data);
		}
	}


	private function ensureSingleSpaceAfterClosingParenthesis()
	{
		if (isset($this->tokens[$this->position]['parenthesis_closer']) === TRUE
			&& isset($this->tokens[$this->position]['scope_opener']) === TRUE
		) {
			$closer = $this->tokens[$this->position]['parenthesis_closer'];
			$opener = $this->tokens[$this->position]['scope_opener'];
			$content = $this->file->getTokensAsString(($closer + 1), ($opener - $closer - 1));
			if ($content !== ' ') {
				$error = 'Expected 1 space after closing parenthesis; found "%s"';
				$data = [str_replace($this->file->eolChar, '\n', $content)];
				$this->file->addError($error, $closer, 'SpaceAfterCloseParenthesis', $data);
			}
		}
	}


	private function ensureNewlineAfterOpeningBrace()
	{
		if (isset($this->tokens[$this->position]['scope_opener']) === TRUE) {
			$opener = $this->tokens[$this->position]['scope_opener'];
			$next = $this->file->findNext(T_WHITESPACE, ($opener + 1), NULL, TRUE);
			$found = ($this->tokens[$next]['line'] - $this->tokens[$opener]['line']);
			if ($found !== 1) {
				if ( ! $this->isCommentOnTheSameLine($this->file, $opener)) {
					$error = 'Expected 1 newline after opening brace; %s found';
					$data = [$found];
					$this->file->addError($error, $opener, 'NewlineAfterOpenBrace', $data);
				}
			}

		} elseif ($this->tokens[$this->position]['code'] === T_WHILE) {
			$closerPosition = $this->tokens[$this->position]['parenthesis_closer'];
			$this->ensureZeroSpacesAfterParenthesisCloser($closerPosition);
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 * @return bool
	 */
	private function isCommentOnTheSameLine(PHP_CodeSniffer_File $file, $position)
	{
		$isComment = $file->findNext(T_COMMENT, ($position + 1), NULL);
		if ($this->tokens[$isComment]['line'] === $this->tokens[$position]['line']) {
			return TRUE;
		}
		return FALSE;
	}


	/**
	 * @param int $closerPosition
	 */
	private function ensureZeroSpacesAfterParenthesisCloser($closerPosition)
	{
		$found = 0;
		if ($this->tokens[($closerPosition + 1)]['code'] === T_WHITESPACE) {
			if (strpos($this->tokens[($closerPosition + 1)]['content'], $this->file->eolChar) !== FALSE) {
				$found = 'newline';

			} else {
				$found = strlen($this->tokens[($closerPosition + 1)]['content']);
			}
		}
		if ($found !== 0) {
			$error = 'Expected 0 spaces before semicolon; %s found';
			$data = [$found];
			$this->file->addError($error, $closerPosition, 'SpaceBeforeSemicolon', $data);
		}
	}

}
