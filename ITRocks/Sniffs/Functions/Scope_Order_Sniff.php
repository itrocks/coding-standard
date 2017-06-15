<?php
namespace ITRocks\Coding_Standard\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Scope_Order_Sniff.
 * Make sure methods of class/interface are ordered alphabetically.
 */
class Scope_Order_Sniff implements Sniff
{
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$tokens = $phpcs_file->getTokens();
		$function = $stack_ptr;

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

				if (isset($previous) && $previous > $current_method_name) {
					$err_msg = sprintf(
						'Methods must be ordered alphabetically: %s() must declared before %s().',
						$current_method_name,
						$previous
					);
					$phpcs_file->addError($err_msg, $scope, 'Invalid');
				}

				$previous = $current_method_name;
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
		];
	}

}
