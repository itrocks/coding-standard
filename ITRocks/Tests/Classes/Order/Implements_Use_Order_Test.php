<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Sniffs\Classes\Implements_Order_Sniff;
use ITRocks\Coding_Standard\Sniffs\Classes\Use_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Bar;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Foo;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Implements_Order_Sniff
 * @see Use_Order_Sniff
 */
class Implements_Use_Order_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------- SOURCE_IMPLEMENTS
	const SOURCE_IMPLEMENTS = 'Coding_Standard.Classes.Implements_Order_.Invalid';

	//------------------------------------------------------------------------------------ SOURCE_USE
	const SOURCE_USE = 'Coding_Standard.Classes.Use_Order_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(5, sprintf(Use_Order_Sniff::ERROR, Bar::class, Foo::class), static::SOURCE_USE),
			new Error(6,
				sprintf(Use_Order_Sniff::ERROR,
					'ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Another', Bar::class),
				static::SOURCE_USE),
			new Error(11, Implements_Order_Sniff::ERROR, static::SOURCE_IMPLEMENTS),
		];
	}

}
