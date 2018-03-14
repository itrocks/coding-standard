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

	//-------------------------------------------------------------------------------- findBlankLines
	/**
	 * Find all blank lines in the given tokens.
	 *
	 * @param $tokens     array
	 * @param $white_list array
	 * @return array
	 */
	private function findBlankLines(array $tokens, $white_list = [T_WHITESPACE])
	{
		$blank_lines = [];
		$ignored = [];

		foreach ($tokens as $token) {
			if (!in_array($token['line'], $ignored)) {
				if (in_array($token['code'], $white_list)) {
					if (!in_array($token['line'], $blank_lines)) {
						$blank_lines[$token['line']] = $token;
					}
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
		$error  = false;
		$tokens = $file->getTokens();
		$lines  = $this->findBlankLines($tokens);

		foreach ($lines as $line => $token) {
			// If there is a blank line right after the current one.
			if (isset($lines[$line+1])) {
				$error = true;
			} else {
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

	//-------------------------------------------------------------------------------------- register
	/**
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
