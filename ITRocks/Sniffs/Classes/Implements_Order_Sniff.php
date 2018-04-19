<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure "implements" statement lists interfaces alphabetically.
 */
class Implements_Order_Sniff implements Sniff
{

	//-------------------------------------------------------------------------- getInterfaceFullName
	/**
	 * Get the full name of an interface, even if its declared using full namespace.
	 *
	 * @param $file  File    The current file.
	 * @param $start integer
	 * @return string
	 */
	private function getInterfaceFullName(File $file, &$start)
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
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$end        = $file->findNext(T_OPEN_CURLY_BRACKET, $stack_ptr+2);
		$interfaces = [];
		$scope      = $stack_ptr;

		while ($scope < $end) {
			$interface = $this->getInterfaceFullName($file, $scope);

			if (!empty($interface)) {
				$interfaces[] = $interface;
			}
			$scope++;
		}

		$sorted = $interfaces;
		asort($interfaces);

		if ($sorted !== $interfaces) {
			$error_message = 'Implemented interfaces must be listed alphabetically';
			$file->addError($error_message, $stack_ptr, 'invalid');
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_IMPLEMENTS];
	}

}
