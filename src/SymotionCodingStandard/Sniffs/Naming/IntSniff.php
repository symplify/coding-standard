<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Naming;


/**
 * Rules:
 * - Integer operator should be spelled 'int'
 */
class IntSniff extends AbstractNamingSniffer
{

	/**
	 * {@inheritdoc}
	 */
	protected function getPossibleForms()
	{
		return ['int', 'integer'];
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getAllowedForm()
	{
		return 'int';
	}


	/**
	 * {@inheritdoc}
	 */
	protected function getErrorMessage()
	{
		return 'Integer operator should be spelled "%s"; "%s" found';
	}

}
