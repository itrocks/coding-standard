<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Constant_Comment_Separator_Sniff;
use ITRocks\Coding_Standard\Sniffs\Comments\Function_Comment_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Function_Comment_Sniff
 */
class Constants_Comment_Test extends Sniff_Test_Case
{
	//-------------------------------------------------------------------------------- SOURCE_INVALID
	const SOURCE_INVALID = 'Coding_Standard.Comments.Constant_Comment_Separator_.Invalid';

	//-------------------------------------------------------------------------------- SOURCE_MISSING
	const SOURCE_MISSING = 'Coding_Standard.Comments.Constant_Comment_Separator_.Missing';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(5, sprintf(Constant_Comment_Separator_Sniff::$messages['Invalid'], 'const', 'GA'),
				static::SOURCE_INVALID),
			new Error(12, sprintf(Constant_Comment_Separator_Sniff::$messages['Missing'], 'const', 'A'),
				static::SOURCE_MISSING),
			new Error(15, sprintf(Constant_Comment_Separator_Sniff::$messages['Invalid'], 'const', 'B'),
				static::SOURCE_INVALID),
		];
	}

}
