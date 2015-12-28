<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Naming;


/**
 * Rules:
 * - Inheritdoc comment should be spelled "{@inheritdoc}".
 */
class InheritDocSniff extends AbstractNamingSniffer
{

	/**
	 * {@inheritdoc}
	 */
	protected function getPossibleForms()
	{
		return [
				'{@inheritDoc}',
				'@inheritDoc',
				'@{inheritDoc}',
				'@{inheritdoc}'
		];
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getAllowedForm()
	{
		return '{@inheritdoc}';
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getErrorMessage()
	{
		return 'Inheritdoc comment should be spelled "%s"; "%s" found';
	}

}
