<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Upper_Snake_Case_Sniff;

/**
 * Class Upper_Snake_Case_Sniff_Test
 */
class Upper_Snake_Case_Sniff_Test extends \PHPUnit_Framework_TestCase
{

	//---------------------------------------------------------------------------------------- $sniff
	/**
	 * The sniff standard to test.
	 *
	 * @var Upper_Snake_Case_Sniff
	 */
	private $sniff;

	//----------------------------------------------------------------------- classNameFormatProvider
	/**
	 * Provides class names for :testFormatUpperSnakeCase().
	 *
	 * @return array
	 */
	public function classNameFormatProvider()
	{
		return [
			['foo', 'Foo'],
			['Foo', 'Foo'],
			['fOo', 'F_Oo'],
			['FOO', 'F_O_O'],
			['FooClass', 'Foo_Class'],
			['foo_class', 'Foo_Class'],
			['Foo_Class', 'Foo_Class'],
			['foo_Class', 'Foo_Class'],
			['FOO_CLASS', 'F_O_O_C_L_A_S_S'],
			['FoO_ClAsS', 'Fo_O_Cl_As_S'],
			['Valid_Foo_Class', 'Valid_Foo_Class'],
			['MixedFoo_Class', 'Mixed_Foo_Class'],
			['Mixed_FooClass', 'Mixed_Foo_Class'],
			['Mixed_Fooclass', 'Mixed_Fooclass'],
		];
	}

	//----------------------------------------------------------------------------- classNameProvider
	/**
	 * Provides class names to test Upper_Snake_Case_Sniff::isValidUpperSnakeCase().
	 *
	 * @return array
	 */
	public function classNameProvider()
	{
		return [
			['foo', false],
			['Foo', true],
			['FooClass', false],
			['foo_class', false],
			['Foo_Class', true],
			['foo_Class', false],
			['FOO', true],
			['FOO_CLASS', true],
			['FoO_ClAsS', false],
			['F00_Cl455', true],
			['Foo__Class', false],
			['Foo_Class_', false],
			[123, false],
		];
	}

	//----------------------------------------------------------------------------------------- setUp
	/**
	 * Before each test.
	 */
	public function setUp()
	{
		$this->sniff = new Upper_Snake_Case_Sniff();
	}

	//-------------------------------------------------------------------------------------- tearDown
	/**
	 * After each test.
	 */
	public function tearDown()
	{
		$this->sniff = null;
	}

	//---------------------------------------------------------------------- testFormatUpperSnakeCase
	/**
	 * @dataProvider classNameFormatProvider
	 * @param $class_name
	 * @param $expected
	 */
	public function testFormatUpperSnakeCase($class_name, $expected)
	{
		$actual = $this->sniff->formatUpperSnakeCase($class_name);

		$this->assertEquals($expected, $actual, $class_name);
	}

	//--------------------------------------------------------------------- testIsValidUpperSnakeCase
	/**
	 * @dataProvider classNameProvider
	 * @param $class_name string  : The class name to validate.
	 * @param $expected   boolean : Expected result for the given class name.
	 */
	public function testIsValidUpperSnakeCase($class_name, $expected)
	{
		$actual = $this->sniff->isValidUpperSnakeCase($class_name);

		$this->assertEquals($expected, $actual, $class_name);
	}

}
