<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Comment_Separator;

/**
 * Class Comment_Separator_Test.
 */
class Comment_Separator_Test extends \PHPUnit_Framework_TestCase
{
	// Use the trait to be able to test its methods.
	use Comment_Separator;

	//---------------------------------------------------------------------------------- nameProvider
	/**
	 * Provides test data for testGetCommentSeparator().
	 *
	 * @return array
	 */
	public function nameProvider()
	{
		return [
			['foo', '//' .  str_repeat('-', 91) . " foo\n"],
			['fooBar', '//' .  str_repeat('-', 88) . " fooBar\n"],
			['foo bar', '//' .  str_repeat('-', 87) . " foo bar\n"],
			['very long string', '//' .  str_repeat('-', 78) . " very long string\n"],
		];
	}

	//----------------------------------------------------------------------- testGetCommentSeparator
	/**
	 * Tests Comment_Separator::getCommentSeparator() with several test parameters.
	 *
	 * @param $name     string
	 * @param $expected string
	 *
	 * @dataProvider nameProvider
	 */
	public function testGetCommentSeparator($name, $expected)
	{
		$actual = $this->getCommentSeparator($name);
		$this->assertEquals($expected, $actual);
	}

}
