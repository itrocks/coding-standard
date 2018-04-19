<?php
namespace ITRocks\Coding_Standard\Tests\Comments\Annotations;

/**
 * Class Dummy_Class
 *
 * @foo1 test
 * @bar1 toto
 *
 * @package1 ITRocks\Coding_Standard\Tests\Comments
 */
class Dummy_Class
{
	//------------------------------------------------------------------------------------------- bar
	/**
	 * @foo2 test
	 * @bar2 toto
	 *
	 * @last2
	 */
	public function bar($a, $b, $c)
	{

	}

	//------------------------------------------------------------------------------------------- foo
	/**
	 * I should have written a blank line
	 * below this one
	 *
	 * @param $a string
	 */
	public function foo($a)
	{

	}

}
