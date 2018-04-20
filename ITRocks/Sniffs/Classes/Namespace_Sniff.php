<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Namespace_Sniff.
 */
class Namespace_Sniff implements Sniff
{
	//------------------------------------------------------------------------------------ ERROR_LINE
	const ERROR_LINE = 'AutoFixable : Namespace should be on line ';

	//-------------------------------------------------------------------------------- ERROR_OPEN_TAG
	const ERROR_OPEN_TAG = 'AutoFixable : Open tag should not be on same line';

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure the namespace statement is at the second line of the file.
	 * No space, no comment, nothing else the opening tag "<?php".
	 *
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$tokens      = $phpcs_file->getTokens();
		$namespace   = $tokens[$stack_ptr];
		$line_number = $namespace['line'];

		// Is there shebang
		$line_offset = strpos($tokens[0]['content'], '#!') === 0 ? 1 : 0;

		// <?php on same line as namespace
		if (isset($tokens[$stack_ptr - 1])
			&& $tokens[$stack_ptr - 1]['code'] === T_OPEN_TAG
			&& $tokens[$stack_ptr - 1]['line'] === $line_number) {
			$fix = $phpcs_file->addFixableError(self::ERROR_OPEN_TAG, $stack_ptr - 1, 'Invalid');
			if ($fix) {
				$phpcs_file->fixer->addNewlineBefore($stack_ptr);
			}
		}
		else if ($line_number !== (2 + $line_offset)) {
			$fix = $phpcs_file->addFixableError(self::ERROR_LINE . (2 + $line_offset), $stack_ptr, 'Invalid');
			if ($fix) {
				$token_navigator = new Token_Navigator($phpcs_file, $stack_ptr);
				$open_tag        = $phpcs_file->findPrevious(T_OPEN_TAG, $stack_ptr);
				$target_line     = $tokens[$open_tag]['line'] + 1;
				$token_navigator->moveLine($line_number, $target_line);
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_NAMESPACE];
	}

}
