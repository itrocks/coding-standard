<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Use_Order_Sniff.
 */
class Use_Order_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure use statements are alphabetically ordered.
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$previous     = '';
		$tokens       = $phpcs_file->getTokens();
		$use_position = $stack_ptr;
		$very_end     = $phpcs_file->findNext(T_CLASS, $use_position+1);

		while($use_position && $use_position < $very_end) {
			$end_of_line   = $phpcs_file->findNext(T_SEMICOLON, $use_position+1);
			$use_statement = '';

			for ($i = $use_position+1; $i < $end_of_line; $i++) {
				$use_statement .= $tokens[$i]['content'];
			}

			// Remove potential comments.
			$use_statement = trim(preg_replace('#(/\*\*?.+\*/)#sU', '', $use_statement));

			if ($previous > $use_statement) {
				$error_message = sprintf(
					'Use statement "%s" should be before "%s"',
					$use_statement,
					$previous
				);
				$phpcs_file->addError($error_message, $use_position, 'invalid');
			}

			$previous     = $use_statement;
			$use_position = $phpcs_file->findNext(T_USE, $use_position+1);
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_USE,
		];
	}

}
