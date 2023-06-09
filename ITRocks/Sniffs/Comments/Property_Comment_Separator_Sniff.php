<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Make sure class's properties have a valid comment separator.
 */
class Property_Comment_Separator_Sniff extends AbstractVariableSniff
{
	use Comment_Separator;

	//------------------------------------------------------------------------------ processMemberVar
	/**
	 * Called to process class member vars.
	 *
	 * {@inheritdoc}
	 */
	protected function processMemberVar(File $phpcs_file, $stack_ptr) : void
	{
		$tokens   = $phpcs_file->getTokens();
		$property = $tokens[$stack_ptr]['content'];
		$this->findError($phpcs_file, $stack_ptr, $property);
	}

	//------------------------------------------------------------------------------- processVariable
	/**
	 * Called to process normal member vars.
	 *
	 * {@inheritdoc}
	 */
	protected function processVariable(File $phpcs_file, $stack_ptr) : void
	{
		// Don't care about normal variables.
	}

	//----------------------------------------------------------------------- processVariableInString
	/**
	 * Called to process variables found in double-quoted strings or heredocs.
	 *
	 * {@inheritdoc}
	 */
	protected function processVariableInString(File $phpcs_file, $stack_ptr) : void
	{
		// Don't care about variables in double quotes.
	}

}
