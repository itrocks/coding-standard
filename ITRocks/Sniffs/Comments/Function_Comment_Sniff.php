<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Function_Comment_Sniff.
 */
class Function_Comment_Sniff implements Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$tokens = $file->getTokens();

		if ($tokens[$stack_ptr]['content'] == '@param' &&
			!preg_match('#^\$#', $tokens[$stack_ptr+2]['content'])
		) {
			$file->addError(
				'PHPdoc param must begin by the variable followed by its type',
				$stack_ptr+2,
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
		return [T_DOC_COMMENT_TAG];
	}

}
