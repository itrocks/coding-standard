<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order\Const_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Const_Order_Sniff
 */
class Const_Order_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Sniffs.Constant_Order.Const_Order_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(13, 'This group of constants must be declared before constant BOOLEAN', static::SOURCE),
			new Error(18, 'This constant must be declared before constant DAA', static::SOURCE),
		];
	}

}
