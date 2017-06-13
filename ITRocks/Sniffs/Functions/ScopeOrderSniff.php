<?php
namespace ITRocks\Coding_Standard\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class ScopeOrderSniff.
 * Make sure methods of class/interface are ordered alphabetically.
 */
class ScopeOrderSniff implements Sniff
{
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		$function = $stackPtr;

		while ($function) {
			$end = null;
			if (isset($tokens[$stackPtr]['scope_closer'])) {
				$end = $tokens[$stackPtr]['scope_closer'];
			}
			$function = $phpcsFile->findNext(T_FUNCTION, $function + 1, $end);

			if (isset($tokens[$function]['parenthesis_opener'])) {
				$scope = $phpcsFile->findNext(
					T_STRING,
					$function + 1,
					$tokens[$function]['parenthesis_opener']
				);

				$current_method_name = $tokens[$scope]['content'];

				if (isset($previous) && $previous > $current_method_name) {
					$err_msg = sprintf('Methods must be ordered alphabetically: %s() must declared before %s().', $current_method_name, $previous);
					$phpcsFile->addError($err_msg, $scope, 'Invalid');
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
