<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Scope_Order_Sniff.
 * Make sure methods of class/interface are ordered alphabetically.
 */
class Method_Order_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$tokens            = $phpcs_file->getTokens();
		$function          = $stack_ptr;
		$correct_methods   = [];
		$misplaced_methods = [];

		while ($function) {
			$end = null;
			if (isset($tokens[$stack_ptr]['scope_closer'])) {
				$end = $tokens[$stack_ptr]['scope_closer'];
			}
			$function = $phpcs_file->findNext(T_FUNCTION, $function + 1, $end);

			if (isset($tokens[$function]['parenthesis_opener'])) {
				$scope = $phpcs_file->findNext(
					T_STRING,
					$function + 1,
					$tokens[$function]['parenthesis_opener']
				);

				$current_method_name = $tokens[$scope]['content'];

				if ($current_method_name < end($correct_methods)) {
					$misplaced_methods[$current_method_name] = $scope;
				}
				else {
					$correct_methods[] = $current_method_name;
				}
			}
		}

		foreach ($misplaced_methods as $method_name => $scope) {
			foreach ($correct_methods as $correct_method_name) {
				if ($method_name < $correct_method_name) {
					$err_msg = sprintf(
						'Methods must be ordered alphabetically: %s() must declared before %s().',
						$method_name,
						$correct_method_name
					);
					$phpcs_file->addError($err_msg, $scope, 'Invalid');
					break;
				}
			}
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
			T_TRAIT,
		];
	}

}
