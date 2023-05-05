<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order;

class Const_Object
{

	//----------------------------------------------------------------------------------------- $line
	/** Line number where the constant is declared */
	public int $line;

	//----------------------------------------------------------------------------------------- $name
	/** Name of the constant */
	public string $name;

	//------------------------------------------------------------------------------------ $stack_ptr
	/** Stack pointer in the process */
	public int $stack_ptr;

	//----------------------------------------------------------------------------------- __construct
	public function __construct(string $name, int $line, int $stack_ptr)
	{
		$this->name      = $name;
		$this->line      = $line;
		$this->stack_ptr = $stack_ptr;
	}

}
