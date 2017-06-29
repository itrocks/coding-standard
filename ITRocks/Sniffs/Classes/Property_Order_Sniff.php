<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Property_Order_Sniff.
 *
 * Throws error if properties of a class are not ordered alphabetically.
 */
class Property_Order_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure class properties are ordered alphabetically.
	 *
	 * @param $phpcs_file File : The file being scanned.
	 * @param $stack_ptr  int  : The position of the current token.
	 * @return void
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$wanted_tokens     = [T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC];
		$previous_property = '';
		$scope             = $phpcs_file->findNext($wanted_tokens, $stack_ptr);
		$tokens            = $phpcs_file->getTokens();

		while($scope) {
			if ($tokens[$scope + 2]['code'] == T_VARIABLE || $tokens[$scope + 4]['code'] == T_VARIABLE) {
				if ($tokens[$scope + 2]['code'] == T_VARIABLE) {
					$property = $tokens[$scope + 2]['content'];
				} else {
					$property = $tokens[$scope + 4]['content'];
				}

				if ($property < $previous_property) {
					$err_msg = sprintf('Property %s must be declared before %s.', $property, $previous_property);
					$phpcs_file->addError($err_msg, $scope, 'Invalid');
				}

				$previous_property = $property;
			}

			$scope = $phpcs_file->findNext($wanted_tokens, $scope+1);
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return [T_CLASS];
	}
}
