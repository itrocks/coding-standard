<?php
namespace ITRocks\Coding_Standard\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Blank_Line_Before_Class_Closing_Brace_Sniff.
 *
 * Ensures there is exactly one blank line before class closing brace, unless class declaration is
 * empty.
 */
class Blank_Line_Before_Class_Closing_Brace_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$tokens           = $file->getTokens();
		$closing_brace    = $tokens[$stack_ptr]['scope_closer'];
		$previous_content = $file->findPrevious(T_WHITESPACE, ($closing_brace - 1), null, true);

		if ($previous_content !== $tokens[$stack_ptr]['scope_opener']
			&& $tokens[$previous_content]['line'] !== ($tokens[$closing_brace]['line'] - 2)
		) {
			$file->addError(
				'There must be exactly one blank line before class closing brace',
				$closing_brace,
				'Invalid'
			);
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
			T_TRAIT,
		];
	}

}
