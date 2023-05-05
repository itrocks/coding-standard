<?php
namespace ITRocks\Coding_Standard\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Ensures there is exactly one blank line before class closing brace, unless class declaration is
 * empty.
 */
class Blank_Line_Before_Class_Closing_Brace_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------------- ERROR
	const ERROR = 'AutoFixable : There must be exactly one blank line before class closing brace';

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		$tokens = $file->getTokens();
		if (array_key_exists('scope_closer', $tokens[$stack_ptr])) {
			$closing_brace    = $tokens[$stack_ptr]['scope_closer'];
			$previous_content = $file->findPrevious(T_WHITESPACE, ($closing_brace - 1), null, true);

			if ($previous_content !== $tokens[$stack_ptr]['scope_opener']
				&& $tokens[$previous_content]['line'] !== ($tokens[$closing_brace]['line'] - 2)
			) {
				$fix = $file->addFixableError(self::ERROR, $closing_brace, 'Invalid');
				if ($fix) {
					$file->fixer->addNewlineBefore($closing_brace);
				}
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
		return [
			T_CLASS,
			T_INTERFACE,
			T_TRAIT,
		];
	}

}
