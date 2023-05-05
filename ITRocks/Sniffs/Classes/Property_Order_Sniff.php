<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Make sure class properties are ordered alphabetically.
 */
class Property_Order_Sniff extends AbstractVariableSniff
{

	//-------------------------------------------------------------------------- ERROR_PROPERTY_ORDER
	const ERROR_PROPERTY_ORDER = 'Property %s must be declared before %s';

	//--------------------------------------------------------------------------------- $current_file
	private static string $current_file = '';

	//----------------------------------------------------------------------------------- $properties
	private static array $properties = [];

	//------------------------------------------------------------------------------ processMemberVar
	/** {@inheritdoc} */
	protected function processMemberVar(File $file, $stack_ptr) : void
	{
		if (static::$current_file !== $file->path) {
			static::$current_file = $file->path;
			static::$properties   = [];
		}

		$tokens   = $file->getTokens();
		$property = $tokens[$stack_ptr]['content'];

		// Append property name in list.
		static::$properties[] = $property;
		$i                    = array_search($property, static::$properties);

		// Check if previous property is alphabetically ordered.
		if (isset(static::$properties[$i - 1])
			&& Clever_String_Compare::snakeCase(static::$properties[$i - 1], $property) > 0) {
			$previous_property = static::$properties[$i - 1];
			$file->addError(self::ERROR_PROPERTY_ORDER, $stack_ptr, 'Invalid', [$property, $previous_property]);
		}
	}

	//------------------------------------------------------------------------------- processVariable
	/** {@inheritdoc} */
	protected function processVariable(File $file, $stack_ptr) : void
	{
		// Don't care about normal variables.
	}

	//----------------------------------------------------------------------- processVariableInString
	/** {@inheritdoc} */
	protected function processVariableInString(File $file, $stack_ptr) : void
	{
		// Don't care about variables in double quotes.
	}

}
