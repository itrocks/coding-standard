<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Function_Comment_Sniff;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Function_Comment_Test.
 */
class Function_Comment_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Function_Comment_Sniff::class;

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Comments.Function_Comment_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			6  => [
				[
					'source'  => self::SOURCE,
					'message' => 'PHPdoc param must begin with the variable name followed by its type',
				],
			],
			18 => [
				[
					'source'  => self::SOURCE,
					'message' => 'PHPdoc param must begin with the variable name followed by its type',
				]
			],
		];
	}

}
