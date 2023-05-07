<?php
namespace ITRocks\Coding_Standard\Tests\Tools;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHPUnit\Framework\TestCase;

/**
 * @see Clever_String_Compare
 */
class Clever_String_Sorter_Test extends TestCase
{

	//----------------------------------------------------------------------------- camelCaseProvider
	/**
	 * @return array<string,array{int,string,string}>
	 * @see testCamelCase
	 */
	public static function camelCaseProvider() : array
	{
		return [
			'Equals'          => [0, 'fooBar', 'fooBar'],
			'Equals empty'    => [0, '', ''],
			'Less As than Bs' => [-1, 'foo', 'fooBar'],
			'Less Bs than As' => [1, 'fooBar', 'foo'],
			'A < B '          => [-1, 'barFoo', 'fooBar'],
			'A > B'           => [1, 'fooBar', 'barFoo'],
		];
	}

	//----------------------------------------------------------------------------- snakeCaseProvider
	/**
	 * @return array<string,array{int,string,string}>
	 * @see testSnakeCase
	 */
	public static function snakeCaseProvider() : array
	{
		return [
			'Equals'          => [0, 'foo_bar', 'foo_bar'],
			'Equals empty'    => [0, '', ''],
			'Less As than Bs' => [-1, 'foo', 'foo_bar'],
			'Less Bs than As' => [1, 'foo_bar', 'foo'],
			'A < B '          => [-1, 'bar_foo', 'foo_bar'],
			'A > B'           => [1, 'foo_bar', 'bar_foo'],
		];
	}

	//------------------------------------------------------------------------------- stringsProvider
	/**
	 * @return array<string,array{int,array<string>,array<string>}>
	 * @see testStrings
	 */
	public static function stringsProvider() : array
	{
		return [
			'Equals'          => [0, ['foo', 'bar'], ['foo', 'bar']],
			'Equals empty'    => [0, [], []],
			'Less As than Bs' => [-1, ['foo'], ['foo', 'bar']],
			'Less Bs than As' => [1, ['foo', 'bar'], ['foo']],
			'A < B '          => [-1, ['bar', 'foo'], ['foo', 'bar']],
			'A > B'           => [1, ['foo', 'bar'], ['bar', 'foo']],
		];
	}

	//--------------------------------------------------------------------------------- testCamelCase
	/** @dataProvider camelCaseProvider */
	public function testCamelCase(int $expected, string $strings_a, string $strings_b) : void
	{
		$this->assertEquals($expected, Clever_String_Compare::camelCase($strings_a, $strings_b));
	}

	//--------------------------------------------------------------------------------- testSnakeCase
	/** @dataProvider snakeCaseProvider */
	public function testSnakeCase(int $expected, string $strings_a, string $strings_b)
	{
		$this->assertEquals($expected, Clever_String_Compare::snakeCase($strings_a, $strings_b));
	}

	//----------------------------------------------------------------------------------- testStrings
	/** @dataProvider stringsProvider */
	public function testStrings(int $expected, array $strings_a, array $strings_b)
	{
		$this->assertEquals($expected, Clever_String_Compare::strings($strings_a, $strings_b));
	}

}
