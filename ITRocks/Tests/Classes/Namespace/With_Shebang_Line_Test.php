<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Namespaces;

use ITRocks\Coding_Standard\Sniffs\Classes\Namespace_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Namespace_Sniff
 */
class With_Shebang_Line_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Namespace_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(2, Namespace_Sniff::ERROR_OPEN_TAG, static::SOURCE),
		];
	}

}
