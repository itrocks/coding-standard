<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Function_Comment_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Function_Comment_Test.
 *
 * @see Function_Comment_Sniff
 */
class Function_Comment_Test extends Sniff_Test_Case
{
	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Function_Comment_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(6, Function_Comment_Sniff::ERROR_ORDER, static::SOURCE),
			new Error(8, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(19, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'String', 'string'), static::SOURCE),
			new Error(25, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'bool', 'boolean'), static::SOURCE),
			new Error(26, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Bool', 'boolean'), static::SOURCE),
			new Error(27, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Boolean', 'boolean'), static::SOURCE),
			new Error(37, Function_Comment_Sniff::ERROR_ORDER, static::SOURCE),
			new Error(39, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(48, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'int', 'integer'), static::SOURCE),
			new Error(49, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Int', 'integer'), static::SOURCE),
			new Error(50, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Integer', 'integer'), static::SOURCE),
			new Error(52, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(61, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'String', 'string'), static::SOURCE),
			new Error(63, Function_Comment_Sniff::ERROR_PATTERN, static::SOURCE),
		];
	}

}
