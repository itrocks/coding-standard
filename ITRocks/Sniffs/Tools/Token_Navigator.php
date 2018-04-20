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

	//--------------------------------------------------------------------------------- $lined_tokens
	/**
	 * @var array
	 */
	public $lined_tokens;

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
		$this->file         = $file;
		$this->stack_ptr    = $stack_ptr;
		$this->lined_tokens = null;
	}

	//----------------------------------------------------------------------------------------- clean
	/**
	 * @param $start integer
	 * @param $end   integer
	 */
	public function clean($start, $end)
	{
		while ($start <= $end) {
			$this->file->fixer->replaceToken($start, null);
			$start++;
		}
	}

	//------------------------------------------------------------------------------------- cleanLine
	/**
	 * @param $line_start integer
	 * @param $line_end   integer
	 */
	public function cleanLine($line_start, $line_end = null)
	{
		if (is_null($line_end)) {
			$line_end = $line_start;
		}
		for ($l = $line_end; $l <= $line_end; $l++) {
			$tokens = $this->getLinedTokens()[$l];
			foreach ($tokens as $scope => $token) {
				$this->file->fixer->replaceToken($scope, null);
			}
		}
	}

	//-------------------------------------------------------------------------------- getLinedTokens
	/**
	 * @return array|null
	 */
	public function getLinedTokens()
	{
		if (!$this->lined_tokens) {
			$this->lined_tokens = [];
			foreach ($this->file->getTokens() as $scope => $token) {
				$line = $token['line'];
				if (!array_key_exists($line, $this->lined_tokens)) {
					$this->lined_tokens[$line] = [];
				}
				$this->lined_tokens[$line][$scope] = $token;
			}
		}
		return $this->lined_tokens;
	}

	//------------------------------------------------------------------------------------- getTokens
	/**
	 * @param $line_start integer
	 * @param $line_end   integer|null
	 * @param $types      array|string|null
	 * @return array
	 */
	public function getTokens($line_start, $line_end = null, $types = null)
	{
		if (is_null($line_end)) {
			$line_end = $line_start;
		}
		$tokens = [];
		while ($line_start <= $line_end) {
			foreach ($this->getLinedTokens()[$line_start] as $pos => $token) {
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
			$line_start++;
		}
		return $tokens;
	}

	//-------------------------------------------------------------------------------------- moveLine
	/**
	 * @param $source integer
	 * @param $target integer
	 */
	public function moveLine($source, $target)
	{
		$tokens  = $this->getLinedTokens()[$source];
		$content = '';
		foreach ($tokens as $scope => $token) {
			$content .= $token['content'];
		}
		$target_pos = array_keys($this->getLinedTokens()[$target])[0];
		$this->file->fixer->addContentBefore($target_pos, $content);
		$this->cleanLine($source);
	}

}
