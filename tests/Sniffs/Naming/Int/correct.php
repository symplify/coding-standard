<?php


class Answer
{

	/**
	 * @param int
	 */
	private $isCorrect = FALSE;

	/**
	 * @param int
	 */
	private $isMisc = FALSE;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $status = TRUE;


	/**
	 * @param int $count Check if integer value is > 0.
	 * @return int
	 */
	public function hasChanged($count = 0)
	{
		/** @var int $hasChecked */
		$hasChecked = '...';
	}

}
