<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure methods of class/interface are ordered alphabetically.
 */
class Method_Order_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = 'Methods must be ordered alphabetically: %s() must declared before %s().';

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		$tokens            = $file->getTokens();
		$function          = $stack_ptr;
		$correct_methods   = [];
		$misplaced_methods = [];

		$depth = 0;
		while ($function) {
			$end = null;
			if (isset($tokens[$stack_ptr]['scope_closer'])) {
				$end = $tokens[$stack_ptr]['scope_closer'];
			}
			do {
				$function ++;
				$token = $tokens[$function] ?? false;
				if (!$token) {
					break 2;
				}
				if ($token['content'] === '{') {
					$depth ++;
				}
				elseif ($token['content'] === '}') {
					$depth --;
					if (!$depth) {
						break 2;
					}
				}
				elseif ($token['code'] === T_ANON_CLASS) {
					$this->process($file, $function);
				}
			} while (!(($depth === 1) && ($token['code'] === T_FUNCTION)));

			if (isset($tokens[$function]['parenthesis_opener'])) {
				$scope = $file->findNext(
					T_STRING,
					$function + 1,
					$tokens[$function]['parenthesis_opener']
				);

				$current_method_name = $tokens[$scope]['content'];
				if ($current_method_name === '&') {
					$scope = $file->findNext(T_STRING, $scope + 1, $end);
					if ($scope) {
						$current_method_name = $tokens[$scope]['content'];
					}
				}
				if (Clever_String_Compare::camelCase($current_method_name, end($correct_methods)) < 0) {
					$misplaced_methods[$current_method_name] = $scope;
				}
				else {
					$correct_methods[] = $current_method_name;
				}
			}
		}

		foreach ($misplaced_methods as $method_name => $scope) {
			foreach ($correct_methods as $correct_method_name) {
				if (Clever_String_Compare::camelCase($method_name, $correct_method_name) < 0) {
					$file->addError(self::ERROR, $scope, 'Invalid', [$method_name, $correct_method_name]);
					break;
				}
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register() : array
	{
		return [
			T_CLASS,
			T_INTERFACE,
			T_TRAIT,
		];
	}

}
