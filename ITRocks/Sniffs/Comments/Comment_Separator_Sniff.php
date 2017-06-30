<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;

/**
 * Class Comment_Separator_Sniff.
 */
class Comment_Separator_Sniff extends Comment_Separator
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure element has a comment separator.
	 *
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$comment = $this->findPreviousComment($file, $stack_ptr);
		$name    = $file->getTokens()[$stack_ptr+2]['content'];

		if (empty($comment)) {
			$this->errorMissingComment($file, $stack_ptr, $name);
		}
		elseif ($comment != $this->getCommentSeparator($name)) {
			$this->errorInvalidComment($file, $stack_ptr, $name);
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_FUNCTION,
			T_CONST,
		];
	}
}
