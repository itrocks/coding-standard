<?php
namespace ITRocks\Coding_Standard\Sniffs\Variables;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

class Valid_Variable_Name_Sniff extends AbstractVariableSniff
{

	//-------------------------------------------------------------------------------- INVALID_FORMAT
	const INVALID_FORMAT = '%s %s is not in valid snake case format.';

	//----------------------------------------------------------------------------------- $white_list
	/** @var string[] List of variable names that should not be validated. */
	public array $white_list = [
		'$GLOBALS',
		'$_SERVER',
		'$_GET',
		'$_POST',
		'$_FILES',
		'$_COOKIE',
		'$_SESSION',
		'$_REQUEST',
		'$_ENV',
	];

	//----------------------------------------------------------------------------------- isSnakeCase
	/**
	 * Returns whether the variable is in snake_case.
	 *
	 * @param string $name The variable name.
	 */
	public function isSnakeCase(string $name) : bool
	{
		return (bool)preg_match('#^\$[a-z0-9_]+$#', $name);
	}

	//-------------------------------------------------------------------------------------- isStatic
	/**
	 * Returns true if property is defined as static, false otherwise.
	 *
	 * @param File $file      The processed file.
	 * @param int  $stack_ptr The token number of the current variable.
	 */
	public function isStatic(File $file, int $stack_ptr) : bool
	{
		$is_static = false;
		$tokens    = $file->getTokens();
		$static    = $file->findPrevious(T_STATIC, $stack_ptr);

		if ($static && $tokens[$static]['line'] == $tokens[$stack_ptr]['line']) {
			$is_static = true;
		}

		return $is_static;
	}

	//----------------------------------------------------------------------------------- isUpperCase
	/**
	 * Returns whether the variable is in upper case.
	 *
	 * @param string $name The name of the variable.
	 */
	public function isUpperCase(string $name) : bool
	{
		return (bool)preg_match('#^\$[A-Z0-9_]+$#', $name);
	}

	//------------------------------------------------------------------------------ isUsedStatically
	/**
	 * Returns true if variable is used like something::$FOO, false otherwise.
	 *
	 * @param array $tokens    The list of tokens for the current parsed document.
	 * @param int   $stack_ptr The token number of the current variable.
	 */
	public function isUsedStatically(array $tokens, int $stack_ptr) : bool
	{
		$used_statically = false;

		if (isset($tokens[$stack_ptr - 1]) && $tokens[$stack_ptr - 1]['code'] == T_DOUBLE_COLON) {
			$used_statically = true;
		}

		return $used_statically;
	}

	//------------------------------------------------------------------------------ processMemberVar
	/** {@inheritdoc} */
	public function processMemberVar(File $file, $stack_ptr) : void
	{
		$tokens        = $file->getTokens();
		$variable_name = $tokens[$stack_ptr]['content'];

		// Static members of a class must be either snake case or uppercase.
		if (!in_array($variable_name, $this->white_list)
			&& !$this->isSnakeCase($variable_name)
			&& $this->isStatic($file, $stack_ptr)
			&& !$this->isUpperCase($variable_name)
		) {
			$file->addError(self::INVALID_FORMAT, $stack_ptr, 'Invalid', ['Property', $variable_name]);
		}
	}

	//------------------------------------------------------------------------- processSimpleVariable
	/**
	 * Called to process normal member vars.
	 *
	 * @param File   $file      The processed file.
	 * @param int    $stack_ptr The token number of the current variable.
	 * @param string $type      Type to display in error message.
	 */
	private function processSimpleVariable(File $file, int $stack_ptr, string $type = 'Variable')
		: void
	{
		$tokens        = $file->getTokens();
		$variable_name = preg_replace('#.*(\$[a-zA-Z0-9_]+).*#', '$1', $tokens[$stack_ptr]['content']);

		if (!in_array($variable_name, $this->white_list) && !$this->isSnakeCase($variable_name)
			&& !$this->isUsedStatically($tokens, $stack_ptr)
		) {
			$file->addError(self::INVALID_FORMAT, $stack_ptr, 'Invalid', [$type, $variable_name]);
		}
	}

	//------------------------------------------------------------------------------- processVariable
	/** {@inheritdoc} */
	public function processVariable(File $file, $stack_ptr) : void
	{
		$this->processSimpleVariable($file, $stack_ptr);
	}

	//----------------------------------------------------------------------- processVariableInString
	/** {@inheritdoc} */
	public function processVariableInString(File $file, $stack_ptr) : void
	{
		$this->processSimpleVariable($file, $stack_ptr, 'Double quoted variable');
	}

}
