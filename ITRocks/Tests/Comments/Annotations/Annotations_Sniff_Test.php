<?php
namespace ITRocks\Coding_Standard\Tests\Comments\Annotations;

use ITRocks\Coding_Standard\Sniffs\Comments\Annotations_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Function_Comment_Test.
 */
class Annotations_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Annotations_Sniff::class;

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Annotations_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(6, 'Annotations must be ordered alphabetically', self::SOURCE),
			new Error(6, 'There must be a blank lines between description and annotations', self::SOURCE),
			new Error(9, 'There must be no blank lines between annotations', self::SOURCE),
			new Error(15, 'Annotations must be ordered alphabetically', self::SOURCE),
			new Error(18, 'There must be no blank lines between annotations', self::SOURCE),
			new Error(29, 'There must be a blank lines between description and annotations', self::SOURCE)
		];
	}

}
