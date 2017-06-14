<?php
namespace ITRocks\Coding_Standard\Sniffs\Variables;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Valid_Variable_Name_Sniff.
 */
class Valid_Variable_Name_Sniff implements Sniff
{

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
	 * @param $name string
	 * @return bool
	 */
	public function isSnakeCase($name)
	{
		return (bool) preg_match( '#^\$[a-z0-9_]+$#', $name );
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$tokens = $phpcs_file->getTokens();
		$variable_name = $tokens[$stack_ptr]['content'];

		if (!in_array($variable_name, $this->white_list) && !$this->isSnakeCase($variable_name)) {
			$error_message = sprintf('Variable %s is not in valid snake case format.', $variable_name);
			$phpcs_file->addError($error_message, $stack_ptr, 'Invalid');
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_VARIABLE,
		];
	}

}
