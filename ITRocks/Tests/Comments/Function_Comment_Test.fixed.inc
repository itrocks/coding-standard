<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

//------------------------------------------------------------------------------------------- foo
/**
 * @param mixed $a
 * @param string $b
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
	 * @param bool    $a
	 * @param bool $b
	 * @param bool $c this is a comment
	 * @param bool $d
	 */
	public function boolean($a, $b, $c, $d)
	{

	}

	//------------------------------------------------------------------------------------------- foo
	/**
	 * @param string $a
	 * @param string $b
	 * @param $c
	 */
	public function foo($a, $b, $c)
	{

	}

	//--------------------------------------------------------------------------------------- integer
	/**
	 * @param int     $a
	 * @param int $b
	 * @param int $c
	 * @param int $d
	 * @param bool
	 * @return
	 */
	public function integer($a, $b, $c, $d)
	{

	}

	//---------------------------------------------------------------------------------------- string
	/**
	 * @param string $a
	 * @param string $b
	 * @param bool With comment
	 * @param
	 */
	public function string($a, $b)
	{

	}

}
