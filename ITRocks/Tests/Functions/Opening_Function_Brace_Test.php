<?php
namespace ITRocks\Coding_Standard\Tests\Formatting;

use ITRocks\Coding_Standard\Sniffs\Functions\Opening_Function_Brace_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Blank_Lines_Test
 *
 * @see Opening_Function_Brace_Sniff
 */
class Opening_Function_Brace_Test extends Sniff_Test_Case
{
	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Functions.Opening_Function_Brace_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return Error[]
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors()
	{
		return [
			NEW Error(22, Opening_Function_Brace_Sniff::ERROR_SAME_LINE, static::SOURCE),
			NEW Error(44, Opening_Function_Brace_Sniff::ERROR_SPACING, static::SOURCE),
			NEW Error(54, Opening_Function_Brace_Sniff::ERROR_SPACING, static::SOURCE),
		];
	}

}
