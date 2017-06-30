<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure "implements" statement lists interfaces alphabetically.
 */
class Implements_Order_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$end       = $phpcs_file->findNext(T_OPEN_CURLY_BRACKET, $stack_ptr);
		$interface = $phpcs_file->findNext(T_STRING, $stack_ptr, $end);
		$previous  = '';
		$tokens    = $phpcs_file->getTokens();

		while ($interface) {
			if ($tokens[$interface]['content'] < $previous) {
				$error_message = 'Implemented interfaces must be listed alphabetically';
				$phpcs_file->addError($error_message, $interface, 'invalid');
				break;
			}

			$previous  = $tokens[$interface]['content'];
			$interface = $phpcs_file->findNext(T_STRING, $interface+1, $end);
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_IMPLEMENTS];
	}
}
