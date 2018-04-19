<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * This sniff makes sure that annotations are ordered alphabetically and grouped together.
 */
class Annotations_Sniff implements Sniff
{

	//----------------------------------------------------------------------- ERROR_ANNOTATIONS_ORDER
	const ERROR_ANNOTATIONS_ORDER = 'Annotations must be ordered alphabetically';
	//------------------------------------------------------------------ ERROR_BLANK_LINE_ANNOTATIONS
	const ERROR_BLANK_LINE_ANNOTATIONS = 'There must be no blank lines between annotations';

	//------------------------------------------------------------ ERROR_BLANK_LINE_BELOW_DESCRIPTION
	const ERROR_BLANK_LINE_BELOW_DESCRIPTION = 'There must be a blank lines between description and annotations';

	//-------------------------------------------------------------------------------- findBlankLines
	/**
	 * Returns true if there is at least one blank line between 2 annotations.
	 *
	 * @param $tokens array   The token list.
	 * @param $start  integer Where to start search for.
	 * @param $stop   integer Where to stop search for.
	 * @return boolean
	 */
	private function findBlankLines(array $tokens, $start, $stop)
	{
		$current_line = $tokens[$stop]['line'];
		$line         = '';

		for ($i = $start; $i < $stop; $i++) {
			$item = $tokens[$i];

			if ($item['line'] == $current_line) {
				$line .= $item['content'];
			}
			else {
				if (trim($line) === '*') {
					return true;
				}

				$current_line = $item['line'];
				$line         = '';
			}
		}

		return false;
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$token_navigator = new Token_Navigator($phpcs_file, $stack_ptr);
		$tokens = $phpcs_file->getTokens();
		$closer = $phpcs_file->findNext(T_DOC_COMMENT_CLOSE_TAG, $stack_ptr);

		if (false !== $next = $phpcs_file->findNext($this->register(), $stack_ptr + 1, $closer)) {
			$first  = $tokens[$stack_ptr]['content'];
			$second = $tokens[$next]['content'];

			if ($first > $second) {
				$phpcs_file->addError(
					self::ERROR_ANNOTATIONS_ORDER,
					$stack_ptr,
					'Invalid'
				);
			}

			if ($tokens[$next]['line'] - $tokens[$stack_ptr]['line'] != 1
				&& $this->findBlankLines($tokens, $stack_ptr, $next)
			) {
				$phpcs_file->addError(
					self::ERROR_BLANK_LINE_ANNOTATIONS,
					$next,
					'Invalid'
				);
			}
		}

		$start    = $phpcs_file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stack_ptr);
		$prev_tag = $phpcs_file->findPrevious(T_DOC_COMMENT_TAG, $stack_ptr - 1, $start);
		$prev_str = $phpcs_file->findPrevious(T_DOC_COMMENT_STRING, $stack_ptr - 1, $start);

		// Check if blank line exist below description
		if ($prev_str && !$prev_tag
			&& $tokens[$prev_str]['line'] === ($tokens[$stack_ptr]['line'] - 1)) {
			$fix = $phpcs_file->addFixableError(
				self::ERROR_BLANK_LINE_BELOW_DESCRIPTION,
				$stack_ptr,
				'Invalid'
			);
			if($fix){
				$first_token = $phpcs_file->findPrevious(T_DOC_COMMENT_STAR, $stack_ptr);
				$phpcs_file->fixer->addContentBefore($first_token, '*'.$phpcs_file->eolChar);
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * efefef
	 *
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_DOC_COMMENT_TAG];
	}

}
