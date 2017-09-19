<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * This sniff makes sure that annotations are ordered alphabetically and grouped together.
 */
class Annotations_Sniff implements Sniff
{

	//-------------------------------------------------------------------------------- findBlankLines
	/**
	 * Returns true if there is at least one blank line between 2 annotations.
	 *
	 * @param $tokens array   The token list.
	 * @param $start  integer Where to start search for.
	 * @param $stop   integer Where to stop search for.
	 * @return bool
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
		$tokens = $phpcs_file->getTokens();
		$closer = $phpcs_file->findNext(T_DOC_COMMENT_CLOSE_TAG, $stack_ptr);

		if (false !== $next = $phpcs_file->findNext($this->register(), $stack_ptr + 1, $closer)) {
			$first  = $tokens[$stack_ptr]['content'];
			$second = $tokens[$next]['content'];

			if ($first > $second) {
				$phpcs_file->addError(
					'Annotations must be ordered alphabetically',
					$stack_ptr,
					'Invalid'
				);
			}

			if ($tokens[$next]['line'] - $tokens[$stack_ptr]['line'] != 1
				&& $this->findBlankLines($tokens, $stack_ptr, $next)
			) {
				$phpcs_file->addError(
					'There must be no blank lines between annotations',
					$next,
					'Invalid'
				);
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_DOC_COMMENT_TAG];
	}

}
