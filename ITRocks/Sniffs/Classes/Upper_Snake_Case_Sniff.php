<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Upper_Snake_Case_Sniff
 * Make sure class names are in valid upper snake case.
 */
class Upper_Snake_Case_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = "%s is not in valid Upper_Snake_Case format";

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

		$class_name = preg_replace_callback($pattern, function (array $matches) {
			return '_' . $matches[0];
		}, $class_name);

		$words       = explode('_', $class_name);
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
	 * @return  boolean
	 */
	public function isValidUpperSnakeCase($class_name)
	{
		if (!is_string($class_name)) {
			return false;
		}

		$words    = explode('_', $class_name);
		$is_valid = true;

		foreach ($words as $word) {
			// Each word must be in full capital letters OR first letter capital followed by lower case letters.
			if (empty($word) || ($word !== ucfirst(strtolower($word)) && $word !== strtoupper($word))) {
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
	public function process(File $file, $stack_ptr)
	{
		$tokens = $file->getTokens();
		$class_name = $tokens[$stack_ptr + 2]['content'];

		if (!$this->isValidUpperSnakeCase($class_name)) {
			$file->addError(self::ERROR, $stack_ptr, 'Invalid', $class_name);
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_CLASS,
			T_INTERFACE,
			T_TRAIT,
		];
	}

}
