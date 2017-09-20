<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Comment_Separator_Sniff.
 * Make sure class's methods & constants have a valid comment separator.
 */
class Comment_Separator_Sniff implements Sniff
{
	use Comment_Separator;

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure element has a comment separator.
	 *
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$comment = $this->findPreviousComment($file, $stack_ptr);

		switch ($file->getTokens()[$stack_ptr]['type']) {
			case 'T_FUNCTION':
				$name = $this->getFunctionName($file, $stack_ptr);
				break;

			case 'T_CONST':
				$name = $this->getConstantName($file, $stack_ptr);
				break;

			default:
				$name = '';
		}

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
