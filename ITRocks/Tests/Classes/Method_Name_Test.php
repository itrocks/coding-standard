<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Method_Name_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Method_Name_Sniff
 */
class Method_Name_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Method_Name_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return Error[]
	 * @see testExpectedErrors
	 */
	public function getExpectedErrors() : array
	{
		return [
			new Error(26, sprintf(Method_Name_Sniff::ERROR, 'not_good'), static::SOURCE),
			new Error(35, sprintf(Method_Name_Sniff::ERROR, 'neitherTH_ISOne'), static::SOURCE),
		];
	}

}
