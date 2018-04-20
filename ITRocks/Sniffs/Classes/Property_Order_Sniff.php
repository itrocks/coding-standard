<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Class Property_Order_Sniff.
 * Make sure class properties are ordered alphabetically.
 */
class Property_Order_Sniff extends AbstractVariableSniff
{

	//-------------------------------------------------------------------------- ERROR_PROPERTY_ORDER
	const ERROR_PROPERTY_ORDER = 'Property %s must be declared before %s';

	//--------------------------------------------------------------------------------- $current_file
	private static $current_file;

	//----------------------------------------------------------------------------------- $properties
	private static $properties = [];

	//------------------------------------------------------------------------------ processMemberVar
	/**
	 * {@inheritdoc}
	 */
	protected function processMemberVar(File $file, $stack_ptr)
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
		if (isset(static::$properties[$i - 1]) && static::$properties[$i - 1] > $property) {
			$previous_property = static::$properties[$i - 1];

			$file->addError(
				sprintf('' . self::ERROR_PROPERTY_ORDER, $property, $previous_property),
				$stack_ptr,
				'Invalid'
			);
		}
	}

	//------------------------------------------------------------------------------- processVariable
	/**
	 * {@inheritdoc}
	 */
	protected function processVariable(File $file, $stack_ptr)
	{
		// Don't care about normal variables.
	}

	//----------------------------------------------------------------------- processVariableInString
	/**
	 * {@inheritdoc}
	 */
	protected function processVariableInString(File $file, $stack_ptr)
	{
		// Don't care about variables in double quotes.
	}

}
