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
 * - New class statement should not have empty parentheses.
 */
final class NewClassSniff implements PHP_CodeSniffer_Sniff
{

	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_NEW];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		if ($this->hasEmptyParentheses($file, $position)) {
			$error = 'New class statement should not have empty parentheses';
			$file->addError($error, $position);
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 * @return bool
	 */
	private function hasEmptyParentheses(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$nextPosition = $position;

		do {
			$nextPosition++;
		} while ( ! $this->doesContentContains($tokens[$nextPosition]['content'], [';', '(', ',', ')']));

		if ($tokens[$nextPosition]['content'] === '(') {
			if ($tokens[$nextPosition + 1]['content'] === ')') {
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @param string $content
	 * @param string[] $chars
	 * @return bool
	 */
	private function doesContentContains($content, array $chars)
	{
		foreach ($chars as $char) {
			if ($content === $char) {
				return TRUE;
			}
		}
		return FALSE;
	}

}
