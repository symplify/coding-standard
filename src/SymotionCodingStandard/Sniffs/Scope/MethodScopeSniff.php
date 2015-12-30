<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Scope;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Standards_AbstractScopeSniff;
use PHP_CodeSniffer_Tokens;


/**
 * Rules:
 * - Function "%s" should have scope modifier.
 * - Interface function "%s" should not have scope modifier.
 */
class MethodScopeSniff extends PHP_CodeSniffer_Standards_AbstractScopeSniff
{

	public function __construct()
	{
		parent::__construct([T_CLASS, T_INTERFACE], [T_FUNCTION]);
	}


	/**
	 * {@inheritdoc}
	 */
	protected function processTokenWithinScope(PHP_CodeSniffer_File $file, $position, $currScope)
	{
		$tokens = $file->getTokens();

		$isClass = $tokens[$currScope]['code'] === T_CLASS;

		$methodName = $file->getDeclarationName($position);
		if ($methodName === NULL) {
			return;
		}

		$pCurly = $file->findPrevious(T_CLOSE_CURLY_BRACKET, $position);
		$modifier = $file->findPrevious(PHP_CodeSniffer_Tokens::$scopeModifiers, $position, max($currScope, $pCurly));

		if ($isClass) {
			if (($modifier === FALSE) || ($tokens[$modifier]['line'] !== $tokens[$position]['line'])) {
				$error = 'Function "%s" should have scope modifier.';
				$data = [$methodName];
				$file->addError($error, $position, '', $data);
			}

		} else {
			if ($modifier !== FALSE) {
				$error = 'Interface function "%s" should not have scope modifier.';
				$data = [$methodName];
				$file->addError($error, $position, '', $data);
			}
		}
	}

}
