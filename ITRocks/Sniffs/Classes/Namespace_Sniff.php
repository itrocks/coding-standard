<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Class Namespace_Sniff.
 */
class Namespace_Sniff extends Sniff
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure the namespace statement is at the second line of the file.
	 * No space, no comment, nothing else the opening tag "<?php".
	 *
	 * {@inheritdoc}
	 */
	public function process(File $phpcs_file, $stack_ptr)
	{
		$tokens = $phpcs_file->getTokens();
		$namespace = $tokens[$stack_ptr];
		$line_number = $namespace['line'];

		if ($line_number != 2) {
			$phpcs_file->addError(
				'Namespace should be at the second line of the file',
				$stack_ptr,
				'Invalid'
			);
		}
		elseif (isset($tokens[$stack_ptr-1]) && $tokens[$stack_ptr-1]['type'] != 'T_OPEN_TAG') {
			$phpcs_file->addError('There must be nothing before namespace', $stack_ptr-1, 'Invalid');
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_NAMESPACE,
		];
	}

}
