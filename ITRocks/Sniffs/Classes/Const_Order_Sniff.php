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
	public function process(File $file, $stack_ptr)
	{
		$const_position = $file->findNext(T_CONST, $stack_ptr + 1);
		$previous       = '';
		$tokens         = $file->getTokens();

		while ($const_position) {
			$constant = $tokens[$const_position + 2]['content'];

			if (strcasecmp($constant, $previous) < 0) {
				$error_message = sprintf(
					'Constant %s must be declared before constant %s',
					$constant,
					$previous
				);

				$file->addError($error_message, $const_position, 'invalid');
			}

			$const_position = $file->findNext(T_CONST, $const_position + 1);
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
