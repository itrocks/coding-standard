<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;

/**
 * Ensures that not grouped constants have a valid comment separator.
 */
class Constant_Comment_Separator_Sniff extends Comment_Separator_Sniff
{

	//------------------------------------------------------------------------------------- isGrouped
	/**
	 * Return true if constant is grouped with others, false otherwise.
	 *
	 * @param $file      File    The processed file object.
	 * @param $stack_ptr integer The current pointer position.
	 * @return boolean
	 */
	private function isGrouped(File $file, $stack_ptr)
	{
		$previous = $file->findPrevious(T_CONST, $stack_ptr-1);
		$tokens   = $file->getTokens();

		if (isset($tokens[$previous]['line'])
			&& $tokens[$stack_ptr]['line'] == ($tokens[$previous]['line'] + 1)
		) {
			return true;
		}

		$next = $file->findNext(T_CONST, $stack_ptr+1);

		if (isset($tokens[$next]['line'])
			&& $tokens[$stack_ptr]['line'] == ($tokens[$next]['line'] - 1)
		) {
			return true;
		}

		return false;
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		if ($this->isGrouped($file, $stack_ptr)) {
			// Skip validation for grouped constants.
			return ;
		}

		parent::process($file, $stack_ptr);
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_CONST];
	}

}
