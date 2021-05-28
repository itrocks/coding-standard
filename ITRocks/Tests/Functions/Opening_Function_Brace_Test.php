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

	//--------------------------------------------------------------------------------------- SOURCE2
	const SOURCE2 = 'Coding_Standard.Functions.Opening_Function_Brace_.BraceOnSameLine';

	//--------------------------------------------------------------------------------------- SOURCE3
	const SOURCE3 = 'Coding_Standard.Functions.Opening_Function_Brace_.BraceSpacing';

	//--------------------------------------------------------------------------------------- SOURCE4
	const SOURCE4 = 'Coding_Standard.Formatting.Multiple_Blank_Lines_.Invalid';

	//--------------------------------------------------------------------------------------- SOURCE5
	const SOURCE5 = 'Coding_Standard.Comments.Comment_Separator_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return Error[]
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors()
	{
		return [
			NEW Error(22, 'Opening brace should be on a new line', static::SOURCE2),
			NEW Error(32, 'Opening brace should be on the line after the declaration; found 1 blank line(s)', static::SOURCE3),
			NEW Error(49, 'Opening brace should be on a new line', static::SOURCE2),
			NEW Error(59, 'AutoFixable : Multiple blank lines are not allowed', static::SOURCE4),
			NEW Error(60, 'Opening brace should be on the line after the declaration; found 2 blank line(s)', static::SOURCE3),
			NEW Error(78, Opening_Function_Brace_Sniff::ERROR_SAME_LINE3, static::SOURCE),
			NEW Error(79, Opening_Function_Brace_Sniff::ERROR_SPACING, static::SOURCE),
			NEW Error(89, Opening_Function_Brace_Sniff::ERROR_SPACING, static::SOURCE),
			NEW Error(99, Opening_Function_Brace_Sniff::ERROR_SPACING, static::SOURCE),
			NEW Error(108, Opening_Function_Brace_Sniff::ERROR_SAME_LINE, static::SOURCE),
			NEW Error(128, Opening_Function_Brace_Sniff::ERROR_SAME_LINE2, static::SOURCE),
			NEW Error(136, Opening_Function_Brace_Sniff::ERROR_SAME_LINE2, static::SOURCE),
			NEW Error(146, Opening_Function_Brace_Sniff::ERROR_SPACING3, static::SOURCE),
			NEW Error(155, Opening_Function_Brace_Sniff::ERROR_SPACING3, static::SOURCE),
			NEW Error(155, Opening_Function_Brace_Sniff::ERROR_SPACING2, static::SOURCE),
			NEW Error(182, Opening_Function_Brace_Sniff::ERROR_SPACING3, static::SOURCE),
			NEW Error(182, Opening_Function_Brace_Sniff::ERROR_SPACING2, static::SOURCE),
			NEW Error(236, Opening_Function_Brace_Sniff::ERROR_SAME_LINE2, static::SOURCE),
			NEW Error(247, Opening_Function_Brace_Sniff::ERROR_SAME_LINE2, static::SOURCE),
			NEW Error(270, 'AutoFixable : Comment separator for function case091complexWithReturnType() is invalid', static::SOURCE5),
			NEW Error(270, Opening_Function_Brace_Sniff::ERROR_SAME_LINE2, static::SOURCE),
		];
	}

}
