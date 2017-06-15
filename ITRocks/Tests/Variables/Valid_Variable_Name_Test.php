<?php
namespace ITRocks\Coding_Standard\Tests\Variables;

use ITRocks\Coding_Standard\Sniffs\Variables\Valid_Variable_Name_Sniff;

/**
 * Class Valid_Variable_Name_Test.
 */
class Valid_Variable_Name_Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Instance of the sniff to test.
	 *
	 * @var Valid_Variable_Name_Sniff
	 */
	private $sniff;

	//----------------------------------------------------------------------------------------- setUp
	/**
	 * Before each test.
	 */
	public function setUp()
	{
		$this->sniff = new Valid_Variable_Name_Sniff();
	}

	//-------------------------------------------------------------------------------------- tearDown
	/**
	 * After each test.
	 */
	public function tearDown()
	{
		$this->sniff = null;
	}

	//------------------------------------------------------------------------------- testIsSnakeCase
	/**
	 * Test Valid_Variable_Name_Sniff::isSnakeCase() in several cases.
	 *
	 * @dataProvider variableNameProvider
	 * @param $name	 string
	 * @param $expected string
	 */
	public function testIsSnakeCase($name, $expected)
	{
		$actual = $this->sniff->isSnakeCase($name);

		$this->assertEquals($expected, $actual, $name);
	}

	//-------------------------------------------------------------------------- variableNameProvider
	/**
	 * Provides several variables names for ::testIsSnakeCase().
	 *
	 * @return array
	 */
	public function variableNameProvider()
	{
		return [
			['', false],
			['$foo', true],
			['$Foo', false],
			['$fOo', false],
			['$FOO', false],
			['$foo_bar', true],
			['$foo_Bar', false],
			['$foo__bar', true],
		];
	}

}
