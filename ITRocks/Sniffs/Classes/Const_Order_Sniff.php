<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Const_Order_Sniff.
 */
class Const_Order_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure class's constants are alphabetically ordered.
	 *
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$const_position = $phpcs_file->findNext(T_CONST, $stack_ptr + 1);
		$previous       = '';
		$tokens         = $phpcs_file->getTokens();

		while ($const_position) {
			$constant = $tokens[$const_position + 2]['content'];

			if ($constant < $previous) {
				$error_message = sprintf(
					'Constant %s must declared before constant %s',
					$constant,
					$previous
				);

				$phpcs_file->addError($error_message, $const_position, 'invalid');
			}

			$const_position = $phpcs_file->findNext(T_CONST, $const_position + 1);
			$previous       = $constant;
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
