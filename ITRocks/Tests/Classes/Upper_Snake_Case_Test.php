<?php declare(strict_types=1);
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Upper_Snake_Case_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Upper_Snake_Case_Sniff_Test
 *
 * @see Upper_Snake_Case_Sniff
 */
class Upper_Snake_Case_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Upper_Snake_Case_.Invalid';

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
			[null, ''],
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

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return Error[]
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(7, sprintf(Upper_Snake_Case_Sniff::ERROR, 'oFo'), static::SOURCE)
		];
	}

	//----------------------------------------------------------------------------------------- setUp
	/**
	 * {@inheritdoc}
	 */
	public function setUp() : void
	{
		parent::setUp();
		$this->sniff = new Upper_Snake_Case_Sniff();
	}

	//-------------------------------------------------------------------------------------- tearDown
	/**
	 * {@inheritdoc}
	 */
	public function tearDown() : void
	{
		$this->sniff = null;
		parent::tearDown();
	}

	//---------------------------------------------------------------------- testFormatUpperSnakeCase
	/**
	 * @dataProvider classNameFormatProvider
	 * @param $class_name string
	 * @param $expected   string
	 */
	public function testFormatUpperSnakeCase($class_name, $expected)
	{
		$actual = $this->sniff->formatUpperSnakeCase($class_name);
		$this->assertEquals($expected, $actual, 'Unexpected class name: '.$class_name);
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
		$this->assertEquals($expected, $actual, 'Unexpected class name: '.$class_name);
	}

}
