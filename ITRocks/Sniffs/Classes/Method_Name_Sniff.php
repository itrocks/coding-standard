<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Method_Name_Sniff
 * Camel case allowing full upper case world
 */
class Method_Name_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = "%s is not in valid camel case format";

	//--------------------------------------------------------------------------------------- isValid
	/**
	 * Returns true if method name is camel case
	 *
	 * @param $method_name string
	 * @return boolean
	 */
	public function isValid($method_name)
	{
		// Must not contains underscore
		if (strpos($method_name, '_') === 0) {
			$method_name = substr($method_name, 1, strlen($method_name) - 1);
			return $this->isValid($method_name);
		}

		$words      = Clever_String_Compare::splitCamelCase($method_name);
		$first_word = array_splice($words, 0, 1);
		$is_valid   = ucfirst(strtolower($first_word[0])) === ucfirst($first_word[0])
			&& strpos($first_word[0], '_') === false;

		if ($is_valid && count($words)) {
			foreach ($words as $word) {
				// Each word must be in full capital letters OR first letter capital followed by lower case letters.
				if (empty($word) || ($word !== ucfirst(strtolower($word)) && $word !== strtoupper($word))
					|| strpos($word, '_') !== false) {
					$is_valid = false;
					break;
				}
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
		$tokens      = $file->getTokens();
		$method_name = $tokens[$stack_ptr + 2]['content'];

		if (!$this->isValid($method_name)) {
			$file->addError(self::ERROR, $stack_ptr, 'Invalid',array($method_name));
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_FUNCTION];
	}

}
