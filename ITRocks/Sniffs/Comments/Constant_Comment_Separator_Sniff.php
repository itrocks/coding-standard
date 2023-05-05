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
	 * @param File $file      The processed file object.
	 * @param int  $stack_ptr The current pointer position.
	 */
	private function isGrouped(File $file, int $stack_ptr) : bool
	{
		$previous = $file->findPrevious(T_CONST, $stack_ptr - 1);
		$tokens   = $file->getTokens();

		if (isset($tokens[$previous]['line'])
			&& $tokens[$stack_ptr]['line'] == ($tokens[$previous]['line'] + 1)
		) {
			return true;
		}

		$next = $file->findNext(T_CONST, $stack_ptr + 1);

		if (isset($tokens[$next]['line'])
			&& $tokens[$stack_ptr]['line'] == ($tokens[$next]['line'] - 1)
		) {
			return true;
		}

		return false;
	}

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		if ($this->isGrouped($file, $stack_ptr)) {
			// Skip validation for grouped constants.
			return;
		}

		$name = $this->getConstantName($file, $stack_ptr);
		$this->findError($file, $stack_ptr, $name);
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register() : array
	{
		return [T_CONST];
	}

}
