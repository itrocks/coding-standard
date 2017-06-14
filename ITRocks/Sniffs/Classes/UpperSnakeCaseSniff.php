<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class UpperSnakeCaseSniff
 * Make sure class names are in valid upper snake case.
 */
class UpperSnakeCaseSniff implements Sniff
{

	//-------------------------------------------------------------------------- formatUpperSnakeCase
	/**
	 * Format the given class name is upper snake case.
	 *
	 * @param $class_name string
	 * @return string
	 */
	public function formatUpperSnakeCase($class_name)
	{
		$pattern = '#([A-Z])#';
		if (!is_string($class_name)) {
			return "";
		}

		$class_name = preg_replace_callback($pattern, function(array $matches) {
			return '_' . $matches[0];
		}, $class_name);

		$words = explode('_', $class_name);
		$output_name = '';

		foreach ($words as $word) {
			if (!empty($word)) {
				$output_name .= ucfirst(strtolower($word)) . '_';
			}
		}

		return rtrim($output_name, '_');
	}

	//------------------------------------------------------------------------- isValidUpperSnakeCase
	/**
	 * Returns true if given class name is a well formed upper snake case, false otherwise.
	 *
	 * @param $class_name string
	 * @return bool
	 */
	public function isValidUpperSnakeCase($class_name)
	{
		if (!is_string($class_name)) {
			return false;
		}

		$words    = explode('_', $class_name);
		$is_valid = true;

		foreach ($words as $word) {
			if (empty($word) || $word !== ucfirst(strtolower($word))) {
				$is_valid = false;
				break;
			}
		}

		return $is_valid;
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		if (isset($tokens[$stackPtr]['scope_closer']) === false) {
			return;
		}

		$class_name = $tokens[$stackPtr+2]['content'];

		if (!$this->isValidUpperSnakeCase($class_name)) {
			$err_msg = sprintf("Class %s should be %s", $class_name, $this->formatUpperSnakeCase($class_name));
			$phpcsFile->addError($err_msg, $stackPtr, 'Invalid');
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_CLASS,
			T_INTERFACE,
		];
	}

}
