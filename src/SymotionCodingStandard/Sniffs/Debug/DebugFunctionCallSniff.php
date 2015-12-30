<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace SymotionCodingStandard\Sniffs\Debug;

use Generic_Sniffs_PHP_ForbiddenFunctionsSniff;


/**
 * Rules:
 * - Debug functions should not be left in the code
 *
 * @author Mikulas Dite <mikulas@dite.pro>
 */
class DebugFunctionCallSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{

	/**
	 * A list of forbidden functions with their alternatives.
	 *
	 * The value is NULL if no alternative exists. IE, the
	 * function should just not be used.
	 *
	 * @var array(string => string|NULL)
	 */
	public $forbiddenFunctions = [
		'd' => NULL,
		'dd' => NULL,
		'dump' => NULL,
		'var_dump' => NULL
	];

}
