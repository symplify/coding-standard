<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Naming;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


abstract class AbstractNamingSniffer implements PHP_CodeSniffer_Sniff
{

	/**
	 * @var array
	 */
	protected $tokens;

	/**
	 * @var PHP_CodeSniffer_File
	 */
	protected $file;

	/**
	 * @var int
	 */
	private $position;


	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_DOC_COMMENT_OPEN_TAG];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;
		$this->tokens = $file->getTokens();

		for (; ! $this->isCommentCloseTagOnPosition($position); $position++) {
			$token = $this->tokens[$position];
			if ($this->isNameInToken($token)) {
				if ( ! $this->isCorrectFormInToken($token)) {
					$this->processIncorrectToken($token);
				}
			}
		}
	}


	/**
	 * @return string[]
	 */
	abstract protected function getPossibleForms();


	/**
	 * @return string
	 */
	abstract protected function getAllowedForm();


	/**
	 * @return string
	 */
	abstract protected function getErrorMessage();


	/**
	 * @param int $position
	 * @return bool
	 */
	private function isCommentCloseTagOnPosition($position)
	{
		$positionCode = $this->tokens[$position]['code'];
		$closeTags = [T_DOC_COMMENT_CLOSE_TAG, T_DOC_COMMENT_CLOSE_TAG];
		return in_array($positionCode, $closeTags);
	}


	/**
	 * @return bool
	 */
	private function isNameInToken(array $token)
	{
		foreach ($this->getPossibleForms() as $nameForm) {
			if ($this->getFirstWord($token['content']) === $nameForm) {
				return TRUE;
			}
		}
		return FALSE;
	}


	/**
	 * @return bool
	 */
	private function isCorrectFormInToken(array $token)
	{
		$content = $this->getFirstWord($token['content']);
		if ($content === $this->getAllowedForm()) {
			return TRUE;
		}
		return FALSE;
	}


	private function processIncorrectToken(array $token)
	{
		$content = explode(' ', $token['content']);
		$foundName = $content = $content[0];
		$data = [$this->getAllowedForm(), $content];
		$fix = $this->file->addFixableError($this->getErrorMessage(), $this->position, '', $data);
		if ($fix) {
			$this->fixViolation($position, $foundName);
		}
	}


	/**
	 * @param string $content
	 * @return string
	 */
	private function getFirstWord($content)
	{
		$list = explode(' ', $content);
		return $list[0];
	}


	/**
	 * @param int $position
	 */
	private function fixViolation($position, $foundName)
	{
		$this->file->fixer->beginChangeset();
		$tokenContent = $this->tokens[$position]['content'];
		$newContent = $this->getAllowedForm() . ltrim($tokenContent, $foundName);
		$this->file->fixer->replaceToken($position, $newContent);
		$this->file->fixer->endChangeset();
	}

}
