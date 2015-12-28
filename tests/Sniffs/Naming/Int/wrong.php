<?php


class Answer
{

	/**
	 * @param integer
	 */
	private $isCorrect = FALSE;

	/**
	 * @ORM\Column(type="integer")
	 * @var integer
	 */
	private $status = TRUE;


	/**
	 * @param integer $strict Check if integer value has changed.
	 * @return integer
	 */
	public function hasChanged($strict = 0)
	{
		/** @var integer $hasChecked */
		$hasChecked = '...';
	}

}
