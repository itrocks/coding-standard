<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

//------------------------------------------------------------------------------------------- foo
/**
 * @param $a mixed
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
	 * @var string
	 */
	public $str;

	//--------------------------------------------------------------------------------------- boolean
	/**
	 * @param $a boolean
	 * @param $b boolean
	 * @param $c boolean  this is a comment
	 * @param $d boolean
	 */
	public function boolean($a, $b, $c, $d)
	{

	}

	//------------------------------------------------------------------------------------------- foo
	/**
	 * @param $a string
	 * @param $b string
	 * @param $c
	 */
	public function foo($a, $b, $c)
	{

	}

	//--------------------------------------------------------------------------------------- integer
	/**
	 * @param $a integer
	 * @param $b integer
	 * @param $c integer
	 * @param $d integer
	 * @return
	 */
	public function integer($a, $b, $c, $d)
	{

	}

	//---------------------------------------------------------------------------------------- string
	/**
	 * @param $a string
	 * @param $b string
	 * @param
	 */
	public function string($a, $b)
	{

	}

}
