<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

//------------------------------------------------------------------------------------------- foo
/**
 * @param mixed $a
 * @param $b string
 * @param $c
 */
function foo($a, $b, $c)
{

}

class Dummy_Class
{
	//------------------------------------------------------------------------------------------ $str
	/**
	 * @var String
	 */
	public $str;

	//--------------------------------------------------------------------------------------- boolean
	/**
	 * @param $a bool
	 * @param $b Bool
	 * @param $c Boolean this is a comment
	 * @param $d boolean
	 */
	public function boolean($a, $b, $c, $d)
	{

	}

	//------------------------------------------------------------------------------------------- foo
	/**
	 * @param string $a
	 * @param $b string
	 * @param $c
	 */
	public function foo($a, $b, $c)
	{

	}

	//--------------------------------------------------------------------------------------- integer
	/**
	 * @param $a int
	 * @param $b Int
	 * @param $c Integer
	 * @param $d integer
	 * @return
	 */
	public function integer($a, $b, $c, $d)
	{

	}

	//---------------------------------------------------------------------------------------- string
	/**
	 * @param $a String
	 * @param $b string
	 * @param
	 */
	public function string($a, $b)
	{

	}

}
