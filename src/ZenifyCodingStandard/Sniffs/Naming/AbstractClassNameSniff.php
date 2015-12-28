<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Naming;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - Abstract class should have prefix "Abstract"
 */
final class AbstractClassNameSniff implements PHP_CodeSniffer_Sniff
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
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_CLASS];
	}


	/**
	 * {@inheritdoc}
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$this->file = $file;
		$this->position = $position;

		if ( ! $this->isClassAbstract()) {
			return;
		}

		if (strpos($this->getClassName(), 'Abstract') === 0) {
			return;
		}

		$file->addError('Abstract class should have prefix "Abstract".', $position);
	}


	/**
	 * @return bool
	 */
	private function isClassAbstract()
	{
		$classProperties = $this->file->getClassProperties($this->position);
		return $classProperties['is_abstract'];
	}


	/**
	 * @return string|FALSE
	 */
	private function getClassName()
	{
		$namePosition = $this->file->findNext(T_STRING, $this->position);
		if ( ! $namePosition) {
			return FALSE;
		}

		return $this->file->getTokens()[$namePosition]['content'];
	}

}
