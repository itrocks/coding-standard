<?php declare(strict_types=1);
namespace ITRocks\Coding_Standard\Tests\Variables;

use ITRocks\Coding_Standard\Sniffs\Variables\Valid_Variable_Name_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Valid_Variable_Name_Sniff
 */
class Valid_Variable_Name_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Variables.Valid_Variable_Name_.Invalid';

	//---------------------------------------------------------------------------------------- $sniff
	/** Instance of the sniff to test. */
	private ?Valid_Variable_Name_Sniff $sniff;

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 *
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors() : array
	{
		return [
			new Error(7, sprintf(Valid_Variable_Name_Sniff::INVALID_FORMAT, 'Property', '$bAr'), static::SOURCE),
			new Error(11, sprintf(Valid_Variable_Name_Sniff::INVALID_FORMAT, 'Variable', '$fOo'), static::SOURCE),
			new Error(12, sprintf(Valid_Variable_Name_Sniff::INVALID_FORMAT, 'Double quoted variable', '$fOo'),
				static::SOURCE)
		];
	}

	//----------------------------------------------------------------------------------------- setUp
	/** {@inheritdoc} */
	public function setUp() : void
	{
		parent::setUp();
		$this->sniff = new Valid_Variable_Name_Sniff();
	}

	//-------------------------------------------------------------------------------------- tearDown
	/** {@inheritdoc} */
	public function tearDown() : void
	{
		$this->sniff = null;
		parent::tearDown();
	}

	//------------------------------------------------------------------------------- testIsSnakeCase
	/**
	 * Test Valid_Variable_Name_Sniff::isSnakeCase() in several cases.
	 *
	 * @dataProvider variableNameProvider
	 */
	public function testIsSnakeCase(string $name, bool $expected) : void
	{
		$actual = $this->sniff->isSnakeCase($name);
		$this->assertEquals($expected, $actual, $name);
	}

	//------------------------------------------------------------------------------- testIsUpperCase
	/**
	 * Test Valid_Variable_Name_Sniff::isUpperCase() in several cases.
	 *
	 * @dataProvider uppercaseProvider
	 */
	public function testIsUpperCase(string $name, bool $expected) : void
	{
		$actual = $this->sniff->isUpperCase($name);
		$this->assertEquals($expected, $actual, $name);
	}

	//----------------------------------------------------------------------------- uppercaseProvider
	/**
	 * Provides several variable names for ::testIsUpperCase().
	 *
	 * @return array<array{string,bool}>
	 */
	public static function uppercaseProvider() : array
	{
		return [
			['',          false],
			['$foo',      false],
			['$Foo',      false],
			['$fOo',      false],
			['$FOO',      true],
			['$FOO_BAR',  true],
			['$foo_bar',  false],
			['$foo_Bar',  false],
			['$foo__bar', false],
		];
	}
	//-------------------------------------------------------------------------- variableNameProvider
	/**
	 * Provides several variables names for ::testIsSnakeCase().
	 *
	 * @return array<array{string,bool}>
	 */
	public static function variableNameProvider() : array
	{
		return [
			['',          false],
			['$foo',      true],
			['$Foo',      false],
			['$fOo',      false],
			['$FOO',      false],
			['$foo_bar',  true],
			['$foo_Bar',  false],
			['$foo__bar', true],
		];
	}

}
