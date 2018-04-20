<?php
namespace ITRocks\Coding_Standard\Sniffs\Functions;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff;

/**
 * Class Opening_Function_Brace_Sniff.
 */
class Opening_Function_Brace_Sniff extends OpeningFunctionBraceBsdAllmanSniff
{

	//------------------------------------------------------------------------------- ERROR_SAME_LINE
	const ERROR_SAME_LINE = 'AutoFixable : Opening brace must be on the same line as closing parenthesis';

	//--------------------------------------------------------------------------------- ERROR_SPACING
	const ERROR_SPACING = 'AutoFixable : There must be one single space between closing parenthesis and opening brace';

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$tokens          = $file->getTokens();
		$token_navigator = new Token_Navigator($file, $stack_ptr);

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
				$fix = $file->addFixableError(self::ERROR_SAME_LINE, $stack_ptr, 'Invalid');
				if ($fix) {
					$file->fixer->replaceToken($brace_opener, ' {');
					$token_navigator->clean($parenthesis_closer + 1, $brace_opener - 1);
				}
			}
			elseif ($brace_opener !== ($parenthesis_closer + 2)
				|| $tokens[($parenthesis_closer + 1)]['code'] != T_WHITESPACE
				|| $tokens[($parenthesis_closer + 1)]['length'] != 1
			) {
				$fix = $file->addFixableError(self::ERROR_SPACING, ($parenthesis_closer + 1), 'Invalid');
				if ($fix) {
					$file->fixer->replaceToken($brace_opener, ' {');
					$token_navigator->clean($parenthesis_closer + 1, $brace_opener - 1);
				}
			}
		}
		else {
			parent::process($file, $stack_ptr);
		}
	}

}
