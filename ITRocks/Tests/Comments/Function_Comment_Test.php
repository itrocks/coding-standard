<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Function_Comment_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Function_Comment_Sniff
 */
class Function_Comment_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Function_Comment_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(7, Function_Comment_Sniff::ERROR_ORDER, static::SOURCE),
			new Error(8, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(19, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'String', 'string'), static::SOURCE),
			new Error(26, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Bool', 'bool'), static::SOURCE),
			new Error(27, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Boolean', 'bool'), static::SOURCE),
			new Error(28, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'boolean', 'bool'), static::SOURCE),
			new Error(38, Function_Comment_Sniff::ERROR_ORDER, static::SOURCE),
			new Error(39, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(49, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Int', 'int'), static::SOURCE),
			new Error(50, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'Integer', 'int'), static::SOURCE),
			new Error(51, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'integer', 'int'), static::SOURCE),
			new Error(52, Function_Comment_Sniff::ERROR_MISSING_PROPERTY, static::SOURCE),
			new Error(53, Function_Comment_Sniff::ERROR_MISSING_TYPE, static::SOURCE),
			new Error(62, sprintf(Function_Comment_Sniff::ERROR_PRIMITIVE, 'String', 'string'), static::SOURCE),
			new Error(64,Function_Comment_Sniff::ERROR_MISSING_PROPERTY, static::SOURCE),
			new Error(65, Function_Comment_Sniff::ERROR_PATTERN, static::SOURCE)
		];
	}

}
