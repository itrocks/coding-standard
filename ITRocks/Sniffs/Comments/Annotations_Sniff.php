<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * This sniff makes sure that annotations are ordered alphabetically and grouped together.
 */
class Annotations_Sniff implements Sniff
{

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
