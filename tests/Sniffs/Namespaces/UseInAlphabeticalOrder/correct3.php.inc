<?php

use A;
use C;


class Presenter
{

	use B;
	use D;


	public function getSome()
	{
		$values = [1, 2];
		array_walk($values, function ($var) use ($ovar) {
			return '';
		});
	}

}
