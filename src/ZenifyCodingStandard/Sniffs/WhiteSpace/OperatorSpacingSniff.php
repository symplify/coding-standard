<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\WhiteSpace;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_Tokens;


/**
 * Rules:
 * - Operator should be surrounded by spaces or on new line.

 * Exceptions:
 * - Function's defaults, ?:, +=, &$var and similar.
 */
final class OperatorSpacingSniff implements PHP_CodeSniffer_Sniff
{

	/**
	 * @var int
	 */
	private $position;

	/**
	 * @var array
	 */
	private $token;

	/**
	 * @var array
	 */
	private $tokens;

	/**
	 * @var PHP_CodeSniffer_File
	 */
	private $file;


	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$tokens = array_merge(
			PHP_CodeSniffer_Tokens::$booleanOperators,
			PHP_CodeSniffer_Tokens::$comparisonTokens,
			PHP_CodeSniffer_Tokens::$operators,
			PHP_CodeSniffer_Tokens::$assignmentTokens,
			[T_INLINE_THEN, T_INLINE_ELSE]
		);

		return $tokens;
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;
		$this->tokens = $file->getTokens();
		$this->token = $this->tokens[$position];

		if ($this->isToBeSkipped()) {
			return;
		}

		$isSpaceBefore = ($this->tokens[$position - 1]['code'] === T_WHITESPACE);
		$isSpaceAfter = ($this->tokens[$position + 1]['code'] === T_WHITESPACE);
		$isNewlineAfter = ($this->tokens[$position]['line'] !== $this->tokens[$position + 2]['line']);

		if ( ! $isSpaceBefore || ! ($isSpaceAfter || $isNewlineAfter) ) {
			$error = 'Operator "%s" should be surrounded by spaces or on new line.';
			$data = [
				$this->tokens[$position]['content']
			];
			$file->addError($error, $position, '', $data);
		}
	}


	/**
	 * @return bool
	 */
	private function isToBeSkipped()
	{
		if ($this->isDefaultValueInFunctionDeclaration()) {
			return TRUE;
		}

		if ($this->isShortTernaryOperator()) {
			return TRUE;
		}

		if ($this->isMinusAssign()) {
			return TRUE;
		}

		if ($this->isReference()) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isDefaultValueInFunctionDeclaration()
	{
		if ($this->isTokenStartOfDefaultValue()) {
			$parenthesis = array_keys($this->token['nested_parenthesis']);
			$bracket = array_pop($parenthesis);
			if (isset($this->tokens[$bracket]['parenthesis_owner']) === TRUE) {
				$function = $this->tokens[$bracket]['parenthesis_owner'];
				if ($this->tokens[$function]['code'] === T_FUNCTION || $this->tokens[$function]['code'] === T_CLOSURE) {
					return TRUE;
				}
			}
		}

		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isTokenStartOfDefaultValue()
	{
		if ($this->token['code'] !== T_EQUAL && $this->token['code'] !== T_MINUS) {
			return FALSE;
		}

		if (isset($this->token['nested_parenthesis'])) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isShortTernaryOperator()
	{
		// *?*:
		if ($this->token['code'] === T_INLINE_THEN && $this->tokens[$this->position + 1]['code'] === T_INLINE_ELSE) {
			return TRUE;
		}

		// ?*:*
		if ($this->tokens[$this->position - 1]['code'] === T_INLINE_THEN && $this->token['code'] === T_INLINE_ELSE) {
			return TRUE;
		}

		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isMinusAssign()
	{
		if ($this->tokens[$this->position]['code'] === T_MINUS) {
			// Check minus spacing, but make sure we aren't just assigning
			// a minus value or returning one.
			$prev = $this->file->findPrevious(T_WHITESPACE, ($this->position - 1), NULL, TRUE);
			if ($this->tokens[$prev]['code'] === T_RETURN) {
				// Just returning a negative value; eg. (return -1).
				return TRUE;
			}

			if (isset(PHP_CodeSniffer_Tokens::$operators[$this->tokens[$prev]['code']]) === TRUE) {
				// Just trying to operate on a negative value; eg. ($var * -1).
				return TRUE;
			}

			if (isset(PHP_CodeSniffer_Tokens::$comparisonTokens[$this->tokens[$prev]['code']]) === TRUE) {
				// Just trying to compare a negative value; eg. ($var === -1).
				return TRUE;
			}

			if (isset(PHP_CodeSniffer_Tokens::$assignmentTokens[$this->tokens[$prev]['code']]) === TRUE) {
				// Just trying to assign a negative value; eg. ($var = -1).
				return TRUE;
			}

			// A list of tokens that indicate that the token is not
			// part of an arithmetic operation.
			$invalidTokens = [
				T_COMMA => TRUE,
				T_OPEN_PARENTHESIS => TRUE,
				T_OPEN_SQUARE_BRACKET => TRUE,
				T_DOUBLE_ARROW => TRUE,
				T_COLON => TRUE,
				T_INLINE_THEN => TRUE,
				T_INLINE_ELSE => TRUE,
				T_CASE => TRUE
			];

			if (isset($invalidTokens[$this->tokens[$prev]['code']]) === TRUE) {
				// Just trying to use a negative value; eg. myFunction($var, -2).
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isReference()
	{
		if ($this->tokens[$this->position]['code'] === T_BITWISE_AND && $this->file->isReference($this->position)) {
			return TRUE;
		}

		return FALSE;
	}

}
