<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Sniffs\Classes\Method_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Scope_Order_Sniff_Test
 *
 * @see Method_Order_Sniff
 */
class Method_Order_Test extends Sniff_Test_Case
{
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
				static::SOURCE),
			new Error(55,
				'Methods must be ordered alphabetically: method03misplaced() must declared before method04().',
				static::SOURCE),
			new Error(59,
				'Methods must be ordered alphabetically: method043misplaced() must declared before method05().',
				static::SOURCE),
			new Error(63,
				'Methods must be ordered alphabetically: method04misplaced() must declared before method05().',
				static::SOURCE)
		];
	}

}
