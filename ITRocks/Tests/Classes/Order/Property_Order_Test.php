<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Sniffs\Classes\Property_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Property_Order__Test
 *
 * @see Property_Order_Sniff
 */
class Property_Order_Test extends Sniff_Test_Case
{
	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Property_Order_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(16, sprintf(Property_Order_Sniff::ERROR_PROPERTY_ORDER, '$_callable', '$boolean'),
				static::SOURCE),
			new Error(22, sprintf(Property_Order_Sniff::ERROR_PROPERTY_ORDER, '$daa', '$foo'), static::SOURCE),
			new Error(25, sprintf(Property_Order_Sniff::ERROR_PROPERTY_ORDER, '$caa', '$daa'), static::SOURCE),
		];
	}

}
