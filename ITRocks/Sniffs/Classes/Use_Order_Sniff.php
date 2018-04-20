<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Use_Order_Sniff.
 */
class Use_Order_Sniff implements Sniff
{
	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = 'AutoFixable : Use statement "%s" should be before "%s"';

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure use statements are alphabetically ordered.
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$fix             = false;
		$token_navigator = new Token_Navigator($phpcs_file, $stack_ptr);
		$tokens          = $phpcs_file->getTokens();
		$previous_line   = 0;
		$use_position    = $stack_ptr;
		$uses            = [];
		$wanted_tokens   = [T_CLASS, T_INTERFACE, T_TRAIT];
		$very_end        = $phpcs_file->findNext($wanted_tokens, $use_position + 1);

		while ($use_position && $use_position < $very_end) {
			$end_of_line   = $phpcs_file->findNext(T_SEMICOLON, $use_position + 1);
			$use_statement = '';

			for ($i = $use_position + 1; $i < $end_of_line; $i++) {
				$use_statement .= $tokens[$i]['content'];
			}

			// Remove potential comments.
			$use_statement = trim(preg_replace('#(/\*\*?.+\*/)#sU', '', $use_statement));

			if ($previous_line && strtolower($uses[$previous_line]) > strtolower($use_statement)) {
				$fix |= $phpcs_file->addFixableError(self::ERROR, $use_position, 'Invalid',
					[$use_statement, $uses[$previous_line]]);
			}

			$previous_line        = $tokens[$end_of_line]['line'];
			$uses[$previous_line] = $use_statement;
			$use_position         = $phpcs_file->findNext(T_USE, $use_position + 1);
		}

		if ($fix) {
			$lines = array_keys($uses);
			$uses  = array_values($uses);
			asort($uses);
			$content = '';
			foreach ($uses as $use) {
				$content .= "use $use;\n";
			}
			$phpcs_file->fixer->replaceToken($stack_ptr, $content);
			foreach ($lines as $line) {
				$token_navigator->cleanLine($line);
			}
		}

		return $very_end;
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_USE,
		];
	}

}
