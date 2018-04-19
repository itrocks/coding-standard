<?php
namespace ITRocks\Coding_Standard\Sniffs\Formatting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Multiple_Blank_Lines_Sniff.
 *
 * Ensures to forbid multiple blank lines.
 */
class Multiple_Blank_Lines_Sniff implements Sniff
{

	//------------------------------------------------------------------- contiguousBlankLinesToError
	/**
	 * Add error on contiguous blank lines.
	 *
	 * @param $file        File  The parsed file
	 * @param $blank_lines array The blank lines found in file
	 */
	private function contiguousBlankLinesToError(File $file, array $blank_lines)
	{
		$error  = false;
		$tokens = $file->getTokens();

		foreach ($blank_lines as $line => $token) {
			// If there is a blank line right after the current one.
			if (isset($blank_lines[$line + 1])) {
				$error = true;
			}
			else {
				if ($error) {
					// The current line is the last one of a group of blank lines.
					$position = array_search($token, $tokens);
					$file->addError('Multiple blank lines are not allowed', $position, 'invalid');
				}

				// Reset error flag.
				$error = false;
			}
		}
	}

	//-------------------------------------------------------------------------------- findBlankLines
	/**
	 * Find all blank lines in the given token list.
	 * Blank lines in comment doc are looked for too.
	 *
	 * @param $tokens     array
	 * @param $white_list array
	 * @return array
	 */
	private function findBlankLines(
		array $tokens, $white_list = [T_WHITESPACE, T_DOC_COMMENT_WHITESPACE, T_DOC_COMMENT_STAR]
	) {
		$blank_lines = [];
		$ignored     = [];

		foreach ($tokens as $token) {
			if (!in_array($token['line'], $ignored)) {
				if (in_array($token['code'], $white_list)) {
					$blank_lines[$token['line']] = $token;
				}
				else {
					$ignored[] = $token['line'];
					unset($blank_lines[$token['line']]);
				}
			}
		}

		return $blank_lines;
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$blank_lines = $this->findBlankLines($file->getTokens());

		$this->contiguousBlankLinesToError($file, $blank_lines);
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_CLASS,
			T_INTERFACE,
			T_TRAIT,
		];
	}

}
