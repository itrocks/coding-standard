<?php
namespace ITRocks\Coding_Standard\Tests\Tools;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHPUnit_Framework_TestCase;

/**
 * Class CleverString_Comparator_Test
 *
 * @see Clever_String_Compare
 */
class Clever_String_Sorter_Test extends PHPUnit_Framework_TestCase
{
	//----------------------------------------------------------------------------- camelCaseProvider
	/**
	 * @return string[]
	 * @see testCamelCase
	 */
	public function camelCaseProvider()
	{
		return [
			'Equals'          => [0, 'fooBar', 'fooBar'],
			'Equals empty'    => [0, '', ''],
			'Less As than Bs' => [-1, 'foo', 'fooBar'],
			'Less Bs than As' => [1, 'fooBar', 'foo'],
			'A < B '          => [-4, 'barFoo', 'fooBar'],
			'A > B'           => [4, 'fooBar', 'barFoo'],
		];
	}

	//----------------------------------------------------------------------------- snakeCaseProvider
	/**
	 * @return string[]
	 * @see testSnakeCase
	 */
	public function snakeCaseProvider()
	{
		return [
			'Equals'          => [0, 'foo_bar', 'foo_bar'],
			'Equals empty'    => [0, '', ''],
			'Less As than Bs' => [-1, 'foo', 'foo_bar'],
			'Less Bs than As' => [1, 'foo_bar', 'foo'],
			'A < B '          => [-4, 'bar_foo', 'foo_bar'],
			'A > B'           => [4, 'foo_bar', 'bar_foo'],
		];
	}

	//------------------------------------------------------------------------------- stringsProvider
	/**
	 * @return string[]
	 * @see testStrings
	 */
	public function stringsProvider()
	{
		return [
			'Equals'          => [0, ['foo', 'bar'], ['foo', 'bar']],
			'Equals empty'    => [0, [], []],
			'Less As than Bs' => [-1, ['foo'], ['foo', 'bar']],
			'Less Bs than As' => [1, ['foo', 'bar'], ['foo']],
			'A < B '          => [-4, ['bar', 'foo'], ['foo', 'bar']],
			'A > B'           => [4, ['foo', 'bar'], ['bar', 'foo']],
		];
	}

	//--------------------------------------------------------------------------------- testCamelCase
	/**
	 * @dataProvider camelCaseProvider
	 * @param $expected  integer
	 * @param $strings_a string
	 * @param $strings_b string
	 */
	public function testCamelCase($expected, $strings_a, $strings_b)
	{
		$this->assertEquals($expected, Clever_String_Compare::camelCase($strings_a, $strings_b));
	}

	//--------------------------------------------------------------------------------- testSnakeCase
	/**
	 * @dataProvider snakeCaseProvider
	 * @param $expected  integer
	 * @param $strings_a string
	 * @param $strings_b string
	 */
	public function testSnakeCase($expected, $strings_a, $strings_b)
	{
		$this->assertEquals($expected, Clever_String_Compare::snakeCase($strings_a, $strings_b));
	}

	//----------------------------------------------------------------------------------- testStrings
	/**
	 * @dataProvider stringsProvider
	 * @param $expected  integer
	 * @param $strings_a string[]
	 * @param $strings_b string[]
	 */
	public function testStrings($expected, $strings_a, $strings_b)
	{
		$this->assertEquals($expected, Clever_String_Compare::strings($strings_a, $strings_b));
	}

}
