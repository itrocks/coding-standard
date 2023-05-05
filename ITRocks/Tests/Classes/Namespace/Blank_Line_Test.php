<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Namespaces;

use ITRocks\Coding_Standard\Sniffs\Classes\Namespace_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Namespace_Sniff
 */
class Blank_Line_Test extends Sniff_Test_Case
{

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'Coding_Standard.Classes.Namespace_.Invalid';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(6, Namespace_Sniff::ERROR_LINE.'2', static::SOURCE),
		];
	}

}
