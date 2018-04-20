<?php
namespace ITRocks\Coding_Standard\Tests\Comments\Annotations;

use ITRocks\Coding_Standard\Sniffs\Comments\Annotations_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Function_Comment_Test
 *
 * @see Annotations_Sniff
 */
class Annotations_Test extends Sniff_Test_Case
{
	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Annotations_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(6, Annotations_Sniff::ERROR_ANNOTATIONS_ORDER, static::SOURCE),
			new Error(6, Annotations_Sniff::ERROR_BLANK_LINE_BELOW_DESCRIPTION, static::SOURCE),
			new Error(9, Annotations_Sniff::ERROR_BLANK_LINE_ANNOTATIONS, static::SOURCE),
			new Error(15, Annotations_Sniff::ERROR_ANNOTATIONS_ORDER, static::SOURCE),
			new Error(18, Annotations_Sniff::ERROR_BLANK_LINE_ANNOTATIONS, static::SOURCE),
			new Error(29, Annotations_Sniff::ERROR_BLANK_LINE_BELOW_DESCRIPTION, static::SOURCE)
		];
	}

}
