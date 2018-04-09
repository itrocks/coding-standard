<?php
namespace ITRocks\Coding_Standard\Tests\Comments\Annotations;

use ITRocks\Coding_Standard\Sniffs\Comments\Annotations_Sniff;
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
			6  => [
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'Annotations must be ordered alphabetically'
				],
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'There must be a blank lines between description and annotations'
				]
			],
			10 => [
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'There must be no blank lines between annotations'
				],
			],
			15 => [
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'Annotations must be ordered alphabetically'
				],
			],
			18 => [
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'There must be no blank lines between annotations'
				],
			],
			28 => [
				[
					Sniff_Test_Case::SOURCE  => self::SOURCE,
					Sniff_Test_Case::MESSAGE => 'There must be a blank lines between description and annotations'
				]
			]
		];
	}

}
