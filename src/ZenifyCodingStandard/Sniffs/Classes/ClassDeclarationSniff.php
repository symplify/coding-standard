<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Classes;

use PEAR_Sniffs_Classes_ClassDeclarationSniff;
use PHP_CodeSniffer_File;


/**
 * Rules (new to parent class):
 * - Opening brace for the %s should be followed by %s empty line(s).
 * - Closing brace for the %s should be preceded by %s empty line(s).
 */
class ClassDeclarationSniff extends PEAR_Sniffs_Classes_ClassDeclarationSniff
{

	/**
	 * @var int
	 */
	public $emptyLinesAfterOpeningBrace = 1;

	/**
	 * @var int
	 */
	public $emptyLinesBeforeClosingBrace = 1;


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		parent::process($file, $position);

		// Fix type
		$this->emptyLinesAfterOpeningBrace = (int) $this->emptyLinesAfterOpeningBrace;
		$this->emptyLinesBeforeClosingBrace = (int) $this->emptyLinesBeforeClosingBrace;

		$this->processOpen($file, $position);
		$this->processClose($file, $position);
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function processOpen(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$openingBracePosition = $tokens[$position]['scope_opener'];
		$emptyLinesCount = $this->getEmptyLinesAfterOpeningBrace($file, $openingBracePosition);

		if ($emptyLinesCount !== $this->emptyLinesAfterOpeningBrace) {
			$error = 'Opening brace for the %s should be followed by %s empty line(s); %s found.';
			$data = [
				$tokens[$position]['content'],
				$this->emptyLinesAfterOpeningBrace,
				$emptyLinesCount,
			];
			$file->addError($error, $openingBracePosition, 'OpenBraceFollowedByEmptyLines', $data);
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	private function processClose(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$closeBracePosition = $tokens[$position]['scope_closer'];
		$emptyLines = $this->getEmptyLinesBeforeClosingBrace($file, $closeBracePosition);

		if ($emptyLines !== $this->emptyLinesBeforeClosingBrace) {
			$error = 'Closing brace for the %s should be preceded by %s empty line(s); %s found.';
			$data = [
				$tokens[$position]['content'],
				$this->emptyLinesBeforeClosingBrace,
				$emptyLines
			];
			$file->addError($error, $closeBracePosition, 'CloseBracePrecededByEmptyLines', $data);
		}
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 * @return array
	 */
	private function getEmptyLinesBeforeClosingBrace(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$prevContent = $file->findPrevious(T_WHITESPACE, ($position - 1), NULL, TRUE);
		return $tokens[$position]['line'] - $tokens[$prevContent]['line'] - 1;
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 * @return int
	 */
	private function getEmptyLinesAfterOpeningBrace(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$nextContent = $file->findNext(T_WHITESPACE, ($position + 1), NULL, TRUE);
		return $tokens[$nextContent]['line'] - $tokens[$position]['line'] - 1;
	}

}
