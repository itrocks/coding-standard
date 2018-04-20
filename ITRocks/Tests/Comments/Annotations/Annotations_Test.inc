<?php
namespace ITRocks\Coding_Standard\Tests\Comments\Annotations;

/**
 * Class Dummy_Class
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
	 *
	 * @return null
	 */
	public function bar($a, $b, $c)
	{
		return;
	}

	//------------------------------------------------------------------------------------------- foo
	/**
	 * I should have written a blank line
	 * below this one
	 * @param $a string Let's write a param comment that will take more than one line to be display, thus checking
	 *           that a multi-lines comment is not triggering empty line between 2 annotations
	 * @param $b string
	 */
	public function foo($a, $b)
	{

	}

}
