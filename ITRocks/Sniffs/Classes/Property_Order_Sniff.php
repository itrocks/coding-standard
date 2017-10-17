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

	//----------------------------------------------------------------------------------- $properties
	private static $properties = [];

	//------------------------------------------------------------------------------ processMemberVar
	/**
	 * Called to process class member vars.
	 *
	 * @param \PHP_CodeSniffer\Files\File $file The PHP_CodeSniffer file where this
	 *                                               token was found.
	 * @param int                         $stack_ptr  The position where the token was found.
	 * @return void
	 */
	protected function processMemberVar(File $file, $stack_ptr)
	{
		$filename = $file->path;
		$tokens   = $file->getTokens();
		$property = $tokens[$stack_ptr]['content'];

		// If key doesn't exist, that means we are processing a new file.
		if (!isset(static::$properties[$filename])) {
			// Thus, clean up array in order to free memory.
			static::$properties = [];
		}

		// Append property name in list.
		static::$properties[$filename][] = $property;

		$properties = static::$properties[$filename];
		$i = array_search($property, $properties);

		// Check if previous property is alphabetically ordered.
		if (isset($properties[$i-1]) && $properties[$i-1] > $property) {
			$previous_property = $properties[$i-1];

			$file->addError(
				sprintf(
					'Property %s must be declared before %s',
					$property,
					$previous_property
				),
				$stack_ptr,
				'Invalid'
			);
		}
	}

	//------------------------------------------------------------------------------- processVariable
	/**
	 * Called to process normal member vars.
	 *
	 * @param \PHP_CodeSniffer\Files\File $file The PHP_CodeSniffer file where this
	 *                                               token was found.
	 * @param int                         $stack_ptr  The position where the token was found.
	 * @return void
	 */
	protected function processVariable(File $file, $stack_ptr)
	{
		// Don't care about normal variables.
	}

	//----------------------------------------------------------------------- processVariableInString
	/**
	 * Called to process variables found in double quoted strings or heredocs.
	 *
	 * Note that there may be more than one variable in the string, which will
	 * result only in one call for the string or one call per line for heredocs.
	 *
	 * @param \PHP_CodeSniffer\Files\File $file The PHP_CodeSniffer file where this
	 *                                          token was found.
	 * @param int                         $stack_ptr  The position where the double quoted
	 *                                               string was found.
	 * @return void
	 */
	protected function processVariableInString(File $file, $stack_ptr)
	{
		// Don't care about variables in double quotes.
	}

}
