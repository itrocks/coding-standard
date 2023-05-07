<?php
namespace ITRocks\Coding_Standard\Sniffs\Tools;

use PHP_CodeSniffer\Files\File;

class Token_Navigator
{

	//----------------------------------------------------------------------------------------- $file
	public File $file;

	//--------------------------------------------------------------------------------- $lined_tokens
	public ?array $lined_tokens;

	//------------------------------------------------------------------------------------ $stack_ptr
	public int $stack_ptr;

	//----------------------------------------------------------------------------------- __construct
	/**
	 * @param File $file
	 * @param int  $stack_ptr
	 */
	public function __construct(File $file, int $stack_ptr)
	{
		$this->file         = $file;
		$this->stack_ptr    = $stack_ptr;
		$this->lined_tokens = null;
	}

	//----------------------------------------------------------------------------------------- clean
	public function clean(int $start, int $end) : void
	{
		while ($start <= $end) {
			$this->file->fixer->replaceToken($start, '');
			$start++;
		}
	}

	//------------------------------------------------------------------------------------- cleanLine
	public function cleanLine(int $line_start, int $line_end = null) : void
	{
		if (is_null($line_end)) {
			$line_end = $line_start;
		}
		for ($l = $line_end; $l <= $line_end; $l++) {
			$tokens = $this->getLinedTokens()[$l];
			foreach ($tokens as $scope => $token) {
				$this->file->fixer->replaceToken($scope, '');
			}
		}
	}

	//-------------------------------------------------------------------------------- getLinedTokens
	public function getLinedTokens() : array
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
	public function getTokens(int $line_start, int $line_end = null, array|string $types = null)
		: array
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
	public function moveLine(int $source, int $target) : void
	{
		$tokens  = $this->getLinedTokens()[$source];
		$content = '';
		foreach ($tokens as $token) {
			$content .= $token['content'];
		}
		$target_pos = array_keys($this->getLinedTokens()[$target])[0];
		$this->file->fixer->addContentBefore($target_pos, $content);
		$this->cleanLine($source);
	}

}
