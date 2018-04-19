<?php
namespace ITRocks\Coding_Standard\Sniffs\Tools;

use PHP_CodeSniffer\Files\File;

/**
 * Class Token_Navigation
 */
class Token_Navigator
{
	//----------------------------------------------------------------------------------------- $file
	/**
	 * @var File
	 */
	public $file;

	//------------------------------------------------------------------------------------ $stack_ptr
	/**
	 * @var integer
	 */
	public $stack_ptr;

	//----------------------------------------------------------------------------------- __construct
	/**
	 * Token_Navigation constructor
	 *
	 * @param $file      File
	 * @param $stack_ptr integer
	 */
	public function __construct(File $file, $stack_ptr)
	{
		$this->file      = $file;
		$this->stack_ptr = $stack_ptr;
	}

	//--------------------------------------------------------------------------- getFirstTokenOfLine
	/**
	 * @return integer
	 */
	public function getFirstTokenOfLine()
	{
		$pos = $this->stack_ptr;
		while ($this->file->getTokens()[$pos]['line'] === $this->file->getTokens()[$this->stack_ptr]['line']) {
			$pos--;
		}
		return $pos;
	}
	//------------------------------------------------------------------------------------- getTokens
	/**
	 * @param $line_start integer
	 * @param $line_end   integer
	 * @param $types      array|string|null
	 * @return array
	 */
	public function getTokens($line_start, $line_end, $types = null)
	{
		$tokens = [];
		foreach ($this->file->getTokens() as $pos => $token) {
			if ($token['line'] < $line_start) continue;
			if ($token['line'] > $line_end) break;

			if (is_null($types)) {
				$tokens[$pos] = $token;
			}
			else {
				$types = is_array($types) ? $types : [$types];
				foreach ($types as $type) {
					if ($token['code'] === $type) {
						$tokens[$pos] = $token;
						break;
					}
				}
			}
		}
		return $tokens;
	}

}
