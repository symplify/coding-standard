<?php


class Answer
{

	/**
	 * @param boolean
	 */
	private $isCorrect = FALSE;

	/**
	 * @ORM\Column(type="boolean")
	 * @var boolean
	 */
	private $status = TRUE;


	/**
	 * @param boolean $strict Check if boolean value has changed.
	 * @return boolean
	 */
	public function hasChanged($strict = FALSE)
	{
		/** @var boolean $hasChecked */
		$hasChecked = '...';
	}

}
