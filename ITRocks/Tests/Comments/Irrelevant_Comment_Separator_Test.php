<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Irrelevant_Comment_Separator_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Irrelevant_Comment_Separator_Sniff
 */
class Irrelevant_Comment_Separator_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Irrelevant_Comment_Separator_.Irrelevant';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritcoc}
	 *
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors() : array
	{
		return [
			new Error(10, Irrelevant_Comment_Separator_Sniff::IRRELEVANT_SEPARATOR, self::SOURCE),
			new Error(12, Irrelevant_Comment_Separator_Sniff::IRRELEVANT_SEPARATOR, self::SOURCE),
		];
	}

}
