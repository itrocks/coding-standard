<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Const_Order_Sniff;
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
					'source'  => 'Coding_Standard.Classes.Const_Order_.invalid',
					'message' => 'Constant _CALLABLE must be declared before constant BOOLEAN',
				],
			],
		];
	}

}
