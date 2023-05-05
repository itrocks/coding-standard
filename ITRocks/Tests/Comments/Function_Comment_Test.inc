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
	 * @param bool    $a
	 * @param Bool    $b
	 * @param Boolean $c this is a comment
	 * @param boolean $d
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
	 * @param int     $a
	 * @param Int     $b
	 * @param Integer $c
	 * @param integer $d
	 * @param bool
	 * @return
	 */
	public function integer($a, $b, $c, $d)
	{

	}

	//---------------------------------------------------------------------------------------- string
	/**
	 * @param String $a
	 * @param string $b
	 * @param bool With comment
	 * @param
	 */
	public function string($a, $b)
	{

	}

}
