<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Method_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Scope_Order_Sniff_Test
 */
class Method_Order_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Method_Order_Sniff::class;

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Method_Order_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(51,
				'Methods must be ordered alphabetically: method02misplaced() must declared before meThod02MisPlacedBis().',
				self::SOURCE),
			new Error(55,
				'Methods must be ordered alphabetically: method03misplaced() must declared before method04().',
				self::SOURCE),
			new Error(59,
				'Methods must be ordered alphabetically: method043misplaced() must declared before method05().',
				self::SOURCE),
			new Error(63,
				'Methods must be ordered alphabetically: method04misplaced() must declared before method05().',
				self::SOURCE)
		];
	}

}
