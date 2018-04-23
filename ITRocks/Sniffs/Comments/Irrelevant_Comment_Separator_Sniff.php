<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Irrelevant_Comment_Separator_Sniff
 */
class Irrelevant_Comment_Separator_Sniff implements Sniff
{

	//-------------------------------------------------------------------------- IRRELEVANT_SEPARATOR
	const IRRELEVANT_SEPARATOR = 'Autofixable : Irrelevant separator';

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		if (strpos($file->getTokens()[$stack_ptr]['content'], '//--') === 0) {
			$found           = false;
			$token_navigator = new Token_Navigator($file, $stack_ptr);
			$line            = $file->getTokens()[$stack_ptr]['line'];
			foreach ($token_navigator->getLinedTokens()[$line + 1] as $token) {
				if ($token['code'] !== T_WHITESPACE && strpos($token['content'], '//--') !== 0) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$fix = $file->addFixableError(self::IRRELEVANT_SEPARATOR, $stack_ptr, 'Irrelevant');
				if ($fix) {
					$token_navigator->cleanLine($line);
				}
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [T_COMMENT];
	}

}
