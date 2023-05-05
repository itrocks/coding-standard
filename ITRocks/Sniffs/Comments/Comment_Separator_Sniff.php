<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
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
	public function process(File $file, $stack_ptr) : void
	{
		$name = $this->getFunctionName($file, $stack_ptr);
		$this->findError($file, $stack_ptr, $name);
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register() : array
	{
		return [T_FUNCTION];
	}

}
