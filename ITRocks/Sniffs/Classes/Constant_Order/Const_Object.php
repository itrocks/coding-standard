<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order;

/**
 * Class Const_Object.
 */
class Const_Object
{

	//----------------------------------------------------------------------------------------- $line
	/**
	 * Line of the were the constant is declared.
	 *
	 * @var integer
	 */
	public $line;

	//----------------------------------------------------------------------------------------- $name
	/**
	 * Name of the constant.
	 *
	 * @var string
	 */
	public $name;

	//------------------------------------------------------------------------------------ $stack_ptr
	/**
	 * Stack pointer in the process.
	 *
	 * @var integer
	 */
	public $stack_ptr;

	//----------------------------------------------------------------------------------- __construct
	/**
	 * Const_Object constructor.
	 *
	 * @param $name      string
	 * @param $line      integer
	 * @param $stack_ptr integer
	 */
	public function __construct($name, $line, $stack_ptr)
	{
		$this->name      = $name;
		$this->line      = $line;
		$this->stack_ptr = $stack_ptr;
	}

}
