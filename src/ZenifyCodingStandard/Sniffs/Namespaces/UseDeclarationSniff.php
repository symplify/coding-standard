<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer_File;
use PSR2_Sniffs_Namespaces_UseDeclarationSniff;


/**
 * Rules:
 * - There must be one USE keyword per declaration
 * - USE declarations must go after the first namespace declaration
 * - There must be 2 blank line(s) after the last USE statement
 */
class UseDeclarationSniff extends PSR2_Sniffs_Namespaces_UseDeclarationSniff
{

	/**
	 * @var int
	 */
	public $blankLinesAfterUseStatement = 2;


	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_USE];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		// Fix types
		$this->blankLinesAfterUseStatement = (int) $this->blankLinesAfterUseStatement;

		if ($this->shouldIgnoreUse($file, $position) === TRUE) {
			return;
		}

		$this->checkIfSingleSpaceAfterUseKeyword($file, $position);
		$this->checkIfOneUseDeclarationPerStatement($file, $position);
		$this->checkIfUseComesAfterNamespaceDeclaration($file, $position);

		// Only interested in the last USE statement from here onwards.
		$nextUse = $file->findNext(T_USE, ($position + 1));
		while ($this->shouldIgnoreUse($file, $nextUse) === TRUE) {
			$nextUse = $file->findNext(T_USE, ($nextUse + 1));
			if ($nextUse === FALSE) {
				break;
			}
		}

		if ($nextUse !== FALSE) {
			return;
		}

		$this->checkBlankLineAfterLastUseStatement($file, $position);
	}


	/**
	 * Check if this use statement is part of the namespace block.
	 *
	 * @param PHP_CodeSniffer_File $file The file being scanned.
	 * @param int $position The position of the current token in the stack passed in $tokens.
	 * @return bool
	 */
	private function shouldIgnoreUse(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();

		// Ignore USE keywords inside closures.
		$next = $file->findNext(T_WHITESPACE, ($position + 1), NULL, TRUE);
		if ($tokens[$next]['code'] === T_OPEN_PARENTHESIS) {
			return TRUE;
		}

		// Ignore USE keywords for traits.
		if ($file->hasCondition($position, [T_CLASS, T_TRAIT]) === TRUE) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function checkIfSingleSpaceAfterUseKeyword(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		if ($tokens[($position + 1)]['content'] !== ' ') {
			$error = 'There must be a single space after the USE keyword';
			$file->addError($error, $position, 'SpaceAfterUse');
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function checkIfOneUseDeclarationPerStatement(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$next = $file->findNext([T_COMMA, T_SEMICOLON], ($position + 1));
		if ($tokens[$next]['code'] === T_COMMA) {
			$error = 'There must be one USE keyword per declaration';
			$file->addError($error, $position, 'MultipleDeclarations');
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function checkIfUseComesAfterNamespaceDeclaration(PHP_CodeSniffer_File $file, $position)
	{
		$prev = $file->findPrevious(T_NAMESPACE, ($position - 1));
		if ($prev !== FALSE) {
			$first = $file->findNext(T_NAMESPACE, 1);
			if ($prev !== $first) {
				$error = 'USE declarations must go after the first namespace declaration';
				$file->addError($error, $position, 'UseAfterNamespace');
			}
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function checkBlankLineAfterLastUseStatement(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$end = $file->findNext(T_SEMICOLON, ($position + 1));
		$next = $file->findNext(T_WHITESPACE, ($end + 1), NULL, TRUE);
		$diff = ($tokens[$next]['line'] - $tokens[$end]['line'] - 1);
		if ($diff !== (int) $this->blankLinesAfterUseStatement) {
			if ($diff < 0) {
				$diff = 0;
			}

			$error = 'There must be %s blank line(s) after the last USE statement; %s found.';
			$data = [$this->blankLinesAfterUseStatement, $diff];
			$file->addError($error, $position, 'SpaceAfterLastUse', $data);
		}
	}

}
