<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Naming;


/**
 * Rules:
 * - Bool operator should be spelled 'bool'
 */
class BoolSniff extends AbstractNamingSniffer
{

	/**
	 * {@inheritdoc}
	 */
	protected function getPossibleForms()
	{
		return ['bool', 'boolean'];
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getAllowedForm()
	{
		return 'bool';
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getErrorMessage()
	{
		return 'Bool operator should be spelled "%s"; "%s" found';
	}

}
