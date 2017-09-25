<?php
namespace ITRocks\Coding_Standard\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff;

/**
 * Class Opening_Function_Brace_Sniff.
 */
class Opening_Function_Brace_Sniff extends OpeningFunctionBraceBsdAllmanSniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$tokens = $file->getTokens();

		// Does not exist for function taking no parameters.
		if (isset($tokens[$stack_ptr]['scope_opener'])) {
			$brace_opener = $tokens[$stack_ptr]['scope_opener'];
		}

		$parenthesis_opener = $tokens[$stack_ptr]['parenthesis_opener'];
		$parenthesis_closer = $tokens[$stack_ptr]['parenthesis_closer'];

		if ($tokens[$parenthesis_closer]['line'] != $tokens[$parenthesis_opener]['line']
			&& isset($brace_opener)
		) {
			// Opening brace must be on the same line as closing parenthesis.
			if ($tokens[$brace_opener]['line'] != $tokens[$parenthesis_closer]['line']) {
				$file->addError('Opening brace must be on the same line as closing parenthesis', $stack_ptr, 'Invalid');
			}
			elseif ($brace_opener != ($parenthesis_closer + 2)
				|| $tokens[($parenthesis_closer + 1)]['type'] != 'T_WHITESPACE'
				|| $tokens[($parenthesis_closer + 1)]['length'] != 1
			) {
				$file->addError(
					'There must be one single space between closing parenthesis and opening brace',
					($parenthesis_closer + 1),
					'Invalid'
				);
			}
		}
		else {
			parent::process($file, $stack_ptr);
		}
	}

}
