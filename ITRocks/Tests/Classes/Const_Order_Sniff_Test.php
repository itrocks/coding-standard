<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order\Const_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Const_Order_Sniff_Test.
 */
class Const_Order_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Const_Order_Sniff::class;

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Sniffs.Constant_Order.Const_Order_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(13, 'This group of constants must be declared before constant BOOLEAN', self::SOURCE),
			new Error(18, 'This constant must be declared before constant DAA', self::SOURCE),
		];
	}

}
