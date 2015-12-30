<?php

/**
 * This file is part of Symplify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymplifyCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - Use statements should be in alphabetical order
 *
 * @author Mikulas Dite <mikulas@dite.pro>
 * @author Tomas Votruba <tomas.vot@gmail.com>
 */
final class UseInAlphabeticalOrderSniff implements PHP_CodeSniffer_Sniff
{

	/**
	 * @var array
	 */
	private $processedFiles = [];

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
		return [T_USE];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;

		if (isset($this->processedFiles[$file->getFilename()])) {
			return;
		}
		$this->processedFiles[$file->getFilename()] = TRUE; // Prevent multiple uses in the same file from entering

		$isClosure = $file->findPrevious([T_CLOSURE], ($position - 1), NULL, FALSE, NULL, TRUE);
		if ($isClosure) {
			return;
		}

		$useStatements = $this->findAllUseStatements();
		$failedIndex = $this->getUseStatementIncorrectOrderPosition($useStatements);
		if ($failedIndex) {
			$error = 'Use statements should be in alphabetical order';
			$file->addError($error, $failedIndex);
		}
	}


	/**
	 * @return array
	 */
	private function findAllUseStatements()
	{
		$uses = [];
		$next = $this->position;
		while (TRUE) {
			$content = '';
			$end = $this->file->findNext([T_SEMICOLON, T_OPEN_CURLY_BRACKET], $next);
			$useTokens = array_slice($this->file->getTokens(), $next, $end - $next, TRUE);
			$index = NULL;
			foreach ($useTokens as $index => $token) {
				if ($token['code'] === T_STRING || $token['code'] === T_NS_SEPARATOR) {
					$content .= $token['content'];
				}
			}
			// Check for class scoping on use. Traits should be ordered independently.
			$scope = 0;
			if ( ! empty($token['conditions'])) {
				$scope = key($token['conditions']);
			}

			if ($this->isUseForNamespaceOrTrait($next)) {
				$content = $this->replaceBackSlashesBySlashes($content);
				$uses[$scope][$content] = $index;
			}

			$next = $this->file->findNext(T_USE, $end);
			if ( ! $next) {
				break;
			}
		}
		return $uses;
	}


	/**
	 * @return int|NULL
	 */
	private function getUseStatementIncorrectOrderPosition(array $uses)
	{
		foreach ($uses as $scope => $used) {
			$defined = $sorted = array_keys($used);

			natcasesort($sorted);
			$sorted = array_values($sorted);
			if ($sorted === $defined) {
				continue;
			}

			foreach ($defined as $i => $name) {
				if ($name !== $sorted[$i]) {
					return $used[$name];
				}
			}
		}
		return NULL;
	}


	/**
	 * @param string $content
	 * @return string
	 */
	private function replaceBackSlashesBySlashes($content)
	{
		return str_replace('\\', '/', $content);
	}


	/**
	 * @param int $position
	 * @return bool
	 */
	private function isUseForNamespaceOrTrait($position)
	{
		$firstLetter = $this->file->getTokens()[$position + 2]['content'];
		if ($firstLetter === '(') { // use ($var)
			return FALSE;
		}
		return TRUE;
	}

}
