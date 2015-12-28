<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Tokens;
use Squiz_Sniffs_ControlStructures_SwitchDeclarationSniff;


class SwitchDeclarationSniff extends Squiz_Sniffs_ControlStructures_SwitchDeclarationSniff
{

	/**
	 * The number of spaces code should be indented.
	 *
	 * @var int
	 */
	public $indent = 1;

	/**
	 * @var array
	 */
	private $token;

	/**
	 * @var array[]
	 */
	private $tokens;

	/**
	 * @var int
	 */
	private $position;

	/**
	 * @var PHP_CodeSniffer_File
	 */
	private $file;


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;

		$this->tokens = $tokens = $file->getTokens();
		$this->token = $tokens[$position];

		if ($this->areSwitchStartAndEndKnown() === FALSE) {
			return;
		}

		$switch = $tokens[$position];
		$nextCase = $position;
		$caseAlignment = ($switch['column'] + $this->indent);
		$caseCount = 0;
		$foundDefault = FALSE;

		$lookFor = [T_CASE, T_DEFAULT, T_SWITCH];
		while (($nextCase = $file->findNext($lookFor, ($nextCase + 1), $switch['scope_closer'])) !== FALSE) {
			// Skip nested SWITCH statements; they are handled on their own.
			if ($tokens[$nextCase]['code'] === T_SWITCH) {
				$nextCase = $tokens[$nextCase]['scope_closer'];
				continue;
			}
			if ($tokens[$nextCase]['code'] === T_DEFAULT) {
				$type = 'Default';
				$foundDefault = TRUE;

			} else {
				$type = 'Case';
				$caseCount++;
			}

			$this->checkIfKeywordIsIndented($file, $nextCase, $tokens, $type, $caseAlignment);
			$this->checkSpaceAfterKeyword($nextCase, $type);

			$opener = $tokens[$nextCase]['scope_opener'];

			$this->ensureNoSpaceBeforeColon($opener, $nextCase, $type);

			$nextBreak = $tokens[$nextCase]['scope_closer'];

			$allowedTokens = [T_BREAK, T_RETURN, T_CONTINUE, T_THROW, T_EXIT];
			if (in_array($tokens[$nextBreak]['code'], $allowedTokens)) {
				$this->processSwitchStructureToken($nextBreak, $nextCase, $caseAlignment, $type, $opener);

			} elseif ($type === 'Default') {
				$error = 'DEFAULT case must have a breaking statement';
				$file->addError($error, $nextCase, 'DefaultNoBreak');
			}
		}

		$this->ensureDefaultIsPresent($foundDefault);
		$this->ensureClosingBraceAlignment($switch);
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 * @param array $tokens
	 * @param string $type
	 * @param int $caseAlignment
	 */
	private function checkIfKeywordIsIndented(PHP_CodeSniffer_File $file, $position, $tokens, $type, $caseAlignment)
	{
		if ($tokens[$position]['column'] !== $caseAlignment) {
			$error = strtoupper($type) . ' keyword must be indented ' . $this->indent . ' spaces from SWITCH keyword';
			$file->addError($error, $position, $type . 'Indent');
		}
	}


	/**
	 * @param int $nextCase
	 * @param int $nextBreak
	 * @param string $type
	 */
	private function checkBreak($nextCase, $nextBreak, $type)
	{
		if ($type === 'Case') {
			// Ensure empty CASE statements are not allowed.
			// They must have some code content in them. A comment is not enough.
			// But count RETURN statements as valid content if they also
			// happen to close the CASE statement.
			$foundContent = FALSE;
			for ($i = ($this->tokens[$nextCase]['scope_opener'] + 1); $i < $nextBreak; $i++) {
				if ($this->tokens[$i]['code'] === T_CASE) {
					$i = $this->tokens[$i]['scope_opener'];
					continue;
				}

				$tokenCode = $this->tokens[$i]['code'];
				$emptyTokens = PHP_CodeSniffer_Tokens::$emptyTokens;
				if (in_array($tokenCode, $emptyTokens) === FALSE) {
					$foundContent = TRUE;
					break;
				}
			}
			if ($foundContent === FALSE) {
				$error = 'Empty CASE statements are not allowed';
				$this->file->addError($error, $nextCase, 'EmptyCase');
			}

		} else {
			// Ensure empty DEFAULT statements are not allowed.
			// They must (at least) have a comment describing why
			// the default case is being ignored.
			$foundContent = FALSE;
			for ($i = ($this->tokens[$nextCase]['scope_opener'] + 1); $i < $nextBreak; $i++) {
				if ($this->tokens[$i]['type'] !== 'T_WHITESPACE') {
					$foundContent = TRUE;
					break;
				}
			}
			if ($foundContent === FALSE) {
				$error = 'Comment required for empty DEFAULT case';
				$this->file->addError($error, $nextCase, 'EmptyDefault');
			}
		}
	}


	/**
	 * @return bool
	 */
	private function areSwitchStartAndEndKnown()
	{
		if ( ! isset($this->tokens[$this->position]['scope_opener'])) {
			return FALSE;
		}

		if ( ! isset($this->tokens[$this->position]['scope_closer'])) {
			return FALSE;
		}

		return TRUE;
	}


	/**
	 * @param int $nextBreak
	 * @param int $nextCase
	 * @param int $caseAlignment
	 * @param string $type
	 * @param int $opener
	 */
	private function processSwitchStructureToken($nextBreak, $nextCase, $caseAlignment, $type, $opener)
	{
		if ($this->tokens[$nextBreak]['scope_condition'] === $nextCase) {
			$this->ensureCaseIndention($nextBreak, $caseAlignment);

			$this->ensureNoBlankLinesBeforeBreak($nextBreak);

			$breakLine = $this->tokens[$nextBreak]['line'];
			$nextLine = $this->getNextLineFromNextBreak($nextBreak);
			if ($type !== 'Case') {
				$this->ensureBreakIsNotFollowedByBlankLine($nextLine, $breakLine, $nextBreak);
			}

			$this->ensureNoBlankLinesAfterStatement($nextCase, $nextBreak, $type, $opener);
		}

		if ($this->tokens[$nextBreak]['code'] === T_BREAK) {
			$this->checkBreak($nextCase, $nextBreak, $type);
		}
	}


	/**
	 * @param int $nextLine
	 * @param int $breakLine
	 * @param int $nextBreak
	 */
	private function ensureBreakIsNotFollowedByBlankLine($nextLine, $breakLine, $nextBreak)
	{
		if ($nextLine !== ($breakLine + 1)) {
			$error = 'Blank lines are not allowed after the DEFAULT case\'s breaking statement';
			$this->file->addError($error, $nextBreak, 'SpacingAfterDefaultBreak');
		}
	}


	/**
	 * @param int $nextBreak
	 */
	private function ensureNoBlankLinesBeforeBreak($nextBreak)
	{
		$prev = $this->file->findPrevious(T_WHITESPACE, ($nextBreak - 1), $this->position, TRUE);
		if ($this->tokens[$prev]['line'] !== ($this->tokens[$nextBreak]['line'] - 1)) {
			$error = 'Blank lines are not allowed before case breaking statements';
			$this->file->addError($error, $nextBreak, 'SpacingBeforeBreak');
		}
	}


	/**
	 * @param int $nextCase
	 * @param int $nextBreak
	 * @param string $type
	 * @param int $opener
	 */
	private function ensureNoBlankLinesAfterStatement($nextCase, $nextBreak, $type, $opener)
	{
		$caseLine = $this->tokens[$nextCase]['line'];
		$nextLine = $this->tokens[$nextBreak]['line'];
		for ($i = ($opener + 1); $i < $nextBreak; $i++) {
			if ($this->tokens[$i]['type'] !== 'T_WHITESPACE') {
				$nextLine = $this->tokens[$i]['line'];
				break;
			}
		}
		if ($nextLine !== ($caseLine + 1)) {
			$error = 'Blank lines are not allowed after ' . strtoupper($type) . ' statements';
			$this->file->addError($error, $nextCase, 'SpacingAfter' . $type);
		}
	}


	/**
	 * @param int $nextBreak
	 * @return int
	 */
	private function getNextLineFromNextBreak($nextBreak)
	{
		$semicolon = $this->file->findNext(T_SEMICOLON, $nextBreak);
		for ($i = ($semicolon + 1); $i < $this->tokens[$this->position]['scope_closer']; $i++) {
			if ($this->tokens[$i]['type'] !== 'T_WHITESPACE') {
				return $this->tokens[$i]['line'];
			}
		}

		return $this->tokens[$this->tokens[$this->position]['scope_closer']]['line'];
	}


	/**
	 * @param int $nextBreak
	 * @param int $caseAlignment
	 */
	private function ensureCaseIndention($nextBreak, $caseAlignment)
	{
		// Only need to check a couple of things once, even if the
		// break is shared between multiple case statements, or even
		// the default case.
		if (($this->tokens[$nextBreak]['column'] - 1) !== $caseAlignment) {
			$error = 'Case breaking statement must be indented ' . ($this->indent + 1) . ' tabs from SWITCH keyword';
			$this->file->addError($error, $nextBreak, 'BreakIndent');
		}
	}


	/**
	 * @param bool $foundDefault
	 */
	private function ensureDefaultIsPresent($foundDefault)
	{
		if ($foundDefault === FALSE) {
			$error = 'All SWITCH statements must contain a DEFAULT case';
			$this->file->addError($error, $this->position, 'MissingDefault');
		}
	}


	private function ensureClosingBraceAlignment(array $switch)
	{
		if ($this->tokens[$switch['scope_closer']]['column'] !== $switch['column']) {
			$error = 'Closing brace of SWITCH statement must be aligned with SWITCH keyword';
			$this->file->addError($error, $switch['scope_closer'], 'CloseBraceAlign');
		}
	}


	/**
	 * @param string $opener
	 * @param int $nextCase
	 * @param string $type
	 */
	private function ensureNoSpaceBeforeColon($opener, $nextCase, $type)
	{
		if ($this->tokens[($opener - 1)]['type'] === 'T_WHITESPACE') {
			$error = 'There must be no space before the colon in a ' . strtoupper($type) . ' statement';
			$this->file->addError($error, $nextCase, 'SpaceBeforeColon' . $type);
		}
	}


	/**
	 * @param int $nextCase
	 * @param string $type
	 */
	private function checkSpaceAfterKeyword($nextCase, $type)
	{
		if ($type === 'Case' && ($this->tokens[($nextCase + 1)]['type'] !== 'T_WHITESPACE'
			|| $this->tokens[($nextCase + 1)]['content'] !== ' ')
		) {
			$error = 'CASE keyword must be followed by a single space';
			$this->file->addError($error, $nextCase, 'SpacingAfterCase');
		}
	}

}
