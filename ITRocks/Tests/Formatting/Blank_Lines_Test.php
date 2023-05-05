<?php
namespace ITRocks\Coding_Standard\Tests\Formatting;

use ITRocks\Coding_Standard\Sniffs\Formatting\Blank_Line_Before_Class_Closing_Brace_Sniff;
use ITRocks\Coding_Standard\Sniffs\Formatting\Multiple_Blank_Lines_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Multiple_Blank_Lines_Sniff
 * @see Blank_Line_Before_Class_Closing_Brace_Sniff
 */
class Blank_Lines_Test extends Sniff_Test_Case
{

	//------------------------------------------------------------------------------------ SOURCE_END
	const SOURCE_END = 'Coding_Standard.Formatting.Blank_Line_Before_Class_Closing_Brace_.Invalid';

	//------------------------------------------------------------------------------- SOURCE_MULTIPLE
	const SOURCE_MULTIPLE = 'Coding_Standard.Formatting.Multiple_Blank_Lines_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 *
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors() : array
	{
		return [
			NEW Error(16, Multiple_Blank_Lines_Sniff::ERROR, static::SOURCE_MULTIPLE),
			NEW Error(27, Multiple_Blank_Lines_Sniff::ERROR, static::SOURCE_MULTIPLE),
			NEW Error(36, Blank_Line_Before_Class_Closing_Brace_Sniff::ERROR, static::SOURCE_END),
		];
	}

}
