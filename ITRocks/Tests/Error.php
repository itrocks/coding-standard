<?php
namespace ITRocks\Coding_Standard\Tests;

class Error
{

	//----------------------------------------------------------------------------------------- $line
	public int $line;

	//-------------------------------------------------------------------------------------- $message
	public string $message;

	//--------------------------------------------------------------------------------------- $source
	public string $source;

	//----------------------------------------------------------------------------------- __construct
	public function __construct(int $line, string $message, string $source)
	{
		$this->line    = $line;
		$this->message = $message;
		$this->source  = $source;
	}

}
