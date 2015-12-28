<?php

/**
 * This file is part of Symotion
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Symotion\FlashMessageComponent;


interface ControlFactory
{

	/**
	 * @return Control
	 */
	function create();

}
