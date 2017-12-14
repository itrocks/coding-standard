<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order\Const_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Const_Order_Sniff_Test.
 */
class Const_Order_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Const_Order_Sniff::class;

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			12 => [
				[
					'source'  => 'Sniffs.Constant_Order.Const_Order_.Invalid',
					'message' => 'This group of constants must be declared before constant BOOLEAN',
				],
			],
			17 => [
				[
					'source'  => 'Sniffs.Constant_Order.Const_Order_.Invalid',
					'message' => 'This constant must be declared before constant DAA',
				]
			],
		];
	}

}
