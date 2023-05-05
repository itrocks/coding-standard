<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure "implements" statement lists interfaces alphabetically.
 */
class Implements_Order_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = 'AutoFixable : Implemented interfaces must be listed alphabetically';

	//-------------------------------------------------------------------------- getInterfaceFullName
	/**
	 * Get the full name of an interface, even if its declared using full namespace.
	 *
	 * @param File $file The current file.
	 */
	private function getInterfaceFullName(File $file, int &$start) : string
	{
		$interface = '';
		$tokens    = $file->getTokens();
		$types     = [T_STRING, T_NS_SEPARATOR];
		$start     = $file->findNext($types, $start);

		while (in_array($tokens[$start]['code'], $types)) {
			$interface .= $tokens[$start]['content'];
			$start++;
		}

		return $interface;
	}

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		$end        = $file->findNext(T_OPEN_CURLY_BRACKET, $stack_ptr + 2);
		$interfaces = [];
		$scope      = $stack_ptr;
		$token_navigator = new Token_Navigator($file, $stack_ptr);

		while ($scope < $end) {
			$interface = $this->getInterfaceFullName($file, $scope);

			if (!empty($interface)) {
				$interfaces[$scope] = $interface;
			}
			$scope++;
		}

		$un_sorted = array_values($interfaces);
		$sorted    = array_values($interfaces);
		asort($sorted);

		if ($un_sorted !== $sorted) {
			$fix = $file->addFixableError(self::ERROR, $stack_ptr, 'Invalid');
			if ($fix) {
				$scope = $stack_ptr + 2;
				$file->fixer->replaceToken($scope, join(', ', $sorted));
				$scope++;
				$token_navigator->clean($scope, $end-2);
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
		return [T_IMPLEMENTS];
	}

}
