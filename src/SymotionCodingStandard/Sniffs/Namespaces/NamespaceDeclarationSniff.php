<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - There must be x empty line(s) after the namespace declaration or y empty line(s) followed by use statement.
 */
final class NamespaceDeclarationSniff implements PHP_CodeSniffer_Sniff
{

	/**
	 * @var int
	 */
	public $emptyLinesAfterNamespace = 2;

	/**
	 * @var int
	 */
	private $emptyLinesBeforeUseStatement;

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
		return [T_NAMESPACE];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;

		// Fix type
		$this->emptyLinesAfterNamespace = (int) $this->emptyLinesAfterNamespace;
		$this->emptyLinesBeforeUseStatement = (int) $this->emptyLinesAfterNamespace - 1;

		$linesToNextUse = $this->getLinesToNextUse();
		$linesToNextClass = $this->getLinesToNextClass();

		if ($linesToNextUse) {
			if ($linesToNextUse !== $this->emptyLinesBeforeUseStatement) {
				$error = 'There should be %s empty line(s) from namespace to use statement; %s found';
				$data = [
					$this->emptyLinesBeforeUseStatement,
					$linesToNextUse
				];
				$file->addError($error, $position, 'BlankLineAfter', $data);
			}

		} elseif ($linesToNextClass) {
			if ($linesToNextClass !== $this->emptyLinesAfterNamespace) {
				$error = 'There should be %s empty line(s) after the namespace declaration; %s found';
				$data = [
					$this->emptyLinesAfterNamespace,
					$linesToNextClass
				];
				$file->addError($error, $position, 'BlankLineAfter', $data);
			}
		}
	}


	/**
	 * @return bool|int
	 */
	private function getLinesToNextUse()
	{
		$tokens = $this->file->getTokens();
		$nextUse = $this->file->findNext(T_USE, $this->position, NULL, FALSE);

		if ($tokens[$nextUse]['line'] === 1 || $this->isInsideClass($nextUse)) {
			return FALSE;

		} else {
			return $tokens[$nextUse]['line'] - $tokens[$this->position]['line'] - 1;
		}
	}


	/**
	 * @return bool|int
	 */
	private function getLinesToNextClass()
	{
		$tokens = $this->file->getTokens();
		$nextClass = $this->file->findNext(
			[T_CLASS, T_INTERFACE, T_TRAIT, T_DOC_COMMENT_OPEN_TAG], $this->position, NULL, FALSE
		);
		if ($tokens[$nextClass]['line'] === 1) {
			return FALSE;

		} else {
			return $tokens[$nextClass]['line'] - $tokens[$this->position]['line'] - 1;
		}
	}


	/**
	 * @param $position
	 * @return bool
	 */
	private function isInsideClass($position)
	{
		$prevClassPosition = $this->file->findPrevious(T_CLASS, $position, NULL, FALSE);
		if ($prevClassPosition) {
			return TRUE;
		}
		return FALSE;
	}

}
