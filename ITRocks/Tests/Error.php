<?php
namespace ITRocks\Coding_Standard\Tests;

class Error
{
	//----------------------------------------------------------------------------------------- $line
	/**
	 * @var integer
	 */
	public $line;

	//-------------------------------------------------------------------------------------- $message
	/**
	 * @var string
	 */
	public $message;

	//--------------------------------------------------------------------------------------- $source
	/**
	 * @var string
	 */
	public $source;

	//----------------------------------------------------------------------------------- __construct
	/**
	 * Error constructor
	 *
	 * @param $line    integer
	 * @param $message string
	 * @param $source  string
	 */
	public function __construct($line, $message, $source)
	{
		$this->line    = $line;
		$this->message = $message;
		$this->source  = $source;
	}

}
