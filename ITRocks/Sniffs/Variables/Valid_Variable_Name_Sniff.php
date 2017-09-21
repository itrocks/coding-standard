<?php
namespace ITRocks\Coding_Standard\Sniffs\Variables;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Class Valid_Variable_Name_Sniff.
 */
class Valid_Variable_Name_Sniff extends AbstractVariableSniff
{

	//-------------------------------------------------------------------------------- INVALID_FORMAT
	const INVALID_FORMAT = '%s %s is not in valid snake case format.';

	//----------------------------------------------------------------------------------- $white_list
	/**
	 * List of variable names that should not be validated.
	 *
	 * @var array
	 */
	public $white_list = [
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
	 * @param $name string The variable name.
	 * @return bool
	 */
	public function isSnakeCase($name)
	{
		return (bool) preg_match( '#^\$[a-z0-9_]+$#', $name );
	}

	//-------------------------------------------------------------------------------------- isStatic
	/**
	 * Returns true if property is defined as static, false otherwise.
	 *
	 * @param $file      File    The processed file.
	 * @param $stack_ptr integer The token number of the current variable.
	 * @return boolean
	 */
	public function isStatic(File $file, $stack_ptr)
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
	 * @param $name string The name of the variable.
	 * @return bool
	 */
	public function isUpperCase($name)
	{
		return (bool) preg_match( '#^\$[A-Z0-9_]+$#', $name );
	}

	//------------------------------------------------------------------------------ isUsedStatically
	/**
	 * Returns true if variable is used like something::$FOO, false otherwise.
	 *
	 * @param $tokens    array   The list of tokens for the current parsed document.
	 * @param $stack_ptr integer The token number of the current variable.
	 * @return boolean
	 */
	public function isUsedStatically(array $tokens, $stack_ptr)
	{
		$used_statically = false;

		if (isset($tokens[$stack_ptr-1]) && $tokens[$stack_ptr-1]['type'] == 'T_DOUBLE_COLON') {
			$used_statically = true;
		}

		return $used_statically;
	}

	//------------------------------------------------------------------------------ processMemberVar
	/**
	 * {@inheritdoc}
	 */
	public function processMemberVar(File $file, $stack_ptr)
	{
		$tokens        = $file->getTokens();
		$variable_name = $tokens[$stack_ptr]['content'];

		// Static members of a class must be either snake case or uppercase.
		if (!in_array($variable_name, $this->white_list)
			&& !$this->isSnakeCase($variable_name)
			&& $this->isStatic($file, $stack_ptr)
			&& !$this->isUpperCase($variable_name)
		) {
			$error_message = sprintf(self::INVALID_FORMAT, 'Property', $variable_name);
			$file->addError($error_message, $stack_ptr, 'Invalid');
		}
	}

	//------------------------------------------------------------------------- processSimpleVariable
	/**
	 * Called to process normal member vars.
	 *
	 * @param $file      File    The processed file.
	 * @param $stack_ptr integer The token number of the current variable.
	 * @param $type      string  Type to display in error message.
	 */
	private function processSimpleVariable(File $file, $stack_ptr, $type = 'Variable')
	{
		$tokens        = $file->getTokens();
		$variable_name = preg_replace('#.*(\$[a-zA-Z0-9_]+).*#', '$1', $tokens[$stack_ptr]['content']);

		if (!in_array($variable_name, $this->white_list) && !$this->isSnakeCase($variable_name)
			&& !$this->isUsedStatically($tokens, $stack_ptr)
		) {
			$error_message = sprintf(self::INVALID_FORMAT, $type, $variable_name);
			$file->addError($error_message, $stack_ptr, 'Invalid');
		}
	}

	//------------------------------------------------------------------------------- processVariable
	/**
	 * {@inheritdoc}
	 */
	public function processVariable(File $file, $stack_ptr)
	{
		$this->processSimpleVariable($file, $stack_ptr);
	}

	//----------------------------------------------------------------------- processVariableInString
	/**
	 * {@inheritdoc}
	 */
	public function processVariableInString(File $file, $stack_ptr)
	{
		$this->processSimpleVariable($file, $stack_ptr, 'Double quoted variable');
	}

}
