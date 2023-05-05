<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

trait Comment_Separator
{

	//--------------------------------------------------------------------------------------- $length
	public int $length = 94;

	//------------------------------------------------------------------------------------- $messages
	public static array $messages = [
		'Invalid' => 'AutoFixable : Comment separator for %s %s is invalid',
		'Missing' => 'AutoFixable : Comment separator is missing for %s %s'
	];

	//----------------------------------------------------------------------------------------- error
	/**
	 * Adds an error at the given position for the given element name.
	 * The type of element is guessed from tokens list.
	 *
	 * @param File   $file       The current parsed file object.
	 * @param int    $stack_ptr  The current pointer position.
	 * @param string $name       The name of the element.
	 * @param string $error_type Type of the error (invalid or missing)
	 * @return array{'type':string,'message':string}
	 */
	private function error(File $file, int $stack_ptr, string $name, string $error_type) : array
	{
		$token = $file->getTokens()[$stack_ptr]['type'];
		$type  = substr(strtolower($token), 2);

		if ($type == 'function') {
			$name .= '()';
		}
		elseif ($type == 'variable') {
			$type = 'property';
		}

		return [
			'type'    => $error_type,
			'message' => sprintf(static::$messages[$error_type], $type, $name)
		];
	}

	//--------------------------------------------------------------------------- errorInvalidComment
	/**
	 * Adds an invalid comment error for given element.
	 *
	 * @param File   $file        The current parsed file object.
	 * @param int    $stack_ptr   The current pointer position.
	 * @param string $name        The name of the element.
	 * @param int    $comment_pos The position of the comment.
	 */
	protected function errorInvalidComment(File $file, int $stack_ptr, string $name, int $comment_pos)
		: void
	{
		$error = $this->error($file, $stack_ptr, $name, 'Invalid');
		$fix   = $file->addFixableError($error['message'], $stack_ptr, $error['type']);
		if ($fix) {
			$file->fixer->replaceToken($comment_pos, $this->getCommentSeparator($name));
		}
	}

	//--------------------------------------------------------------------------- errorMissingComment
	/**
	 * Adds a missing comment error for given element.
	 *
	 * @param File   $file        The current parsed file object.
	 * @param int    $stack_ptr   The current pointer position.
	 * @param string $name        The name of the element.
	 * @param int    $comment_pos The position of the comment.
	 */
	protected function errorMissingComment(File $file, int $stack_ptr, string $name, int $comment_pos)
		: void
	{
		$error = $this->error($file, $stack_ptr, $name, 'Missing');
		$fix   = $file->addFixableError($error['message'], $stack_ptr, $error['type']);
		if ($fix) {
			$file->fixer->addContentBefore($comment_pos, $this->getCommentSeparator($name));
			$file->fixer->addNewlineBefore($comment_pos);
		}
	}

	//------------------------------------------------------------------------------------- findError
	/**
	 * @param File   $file      The current parsed file object.
	 * @param int    $stack_ptr The current pointer position.
	 * @param string $name      The name of the element.
	 */
	public function findError(File $file, int $stack_ptr, string $name) : void
	{
		$token_navigator = new Token_Navigator($file, $stack_ptr);
		$line            = $file->getTokens()[$stack_ptr]['line'];

		// Is there attribute(s) before ?
		$tokens  = $token_navigator->getTokens($line - 1, $line - 1, T_ATTRIBUTE_END);
		while ($line && $tokens) {
			$open_tag = $file->findPrevious(T_ATTRIBUTE, array_key_last($tokens));
			$line     = $file->getTokens()[$open_tag]['line'];
			$tokens   = $token_navigator->getTokens($line - 1, $line - 1, T_ATTRIBUTE_END);
		}

		// Is there doc before ?
		$tokens = $token_navigator->getTokens($line - 1, $line - 1, T_DOC_COMMENT_CLOSE_TAG);
		if (count($tokens) > 0) {
			$open_tag = $file->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stack_ptr);
			$line     = $file->getTokens()[$open_tag]['line'];
		}
		$tokens = $token_navigator->getTokens($line - 1, $line - 1, Tokens::$commentTokens);

		$found = false;
		foreach ($tokens as $pos => $token) {
			if ($token['code'] === T_COMMENT) {
				$found = true;
				if ($token['content'] != $this->getCommentSeparator($name)) {
					$this->errorInvalidComment($file, $stack_ptr, $name, $pos);
				}
			}
		}
		if (!$found) {
			$tokens = $token_navigator->getTokens($line);
			$first  = array_keys($tokens)[0];
			$this->errorMissingComment($file, $stack_ptr, $name, $first);
		}
	}

	//--------------------------------------------------------------------------- getCommentSeparator
	/** Generates a comment separator for the given name. */
	public function getCommentSeparator(string $name) : string
	{
		return '//' . str_repeat('-', $this->length - strlen($name)) . ' ' . $name . chr(10);
	}

	//------------------------------------------------------------------------------- getConstantName
	/**
	 * Get the constant name starting search from $start position.
	 * A class constant declaration always ends by a semicolon.
	 */
	public function getConstantName(File $file, int $start) : string
	{
		return $this->getElementName($file, $start, T_SEMICOLON);
	}

	//-------------------------------------------------------------------------------- getElementName
	/**
	 * Get the name of an element starting search from $start.
	 *
	 * @param mixed $stop_type The element type ending the declaration of the searched element.
	 */
	private function getElementName(File $file, int $start, mixed $stop_type) : string
	{
		$element_name = '';
		$end          = $file->findNext($stop_type, $start);
		$position     = $file->findNext(T_STRING, $start, $end);

		if ($position) {
			$element_name = $file->getTokens()[$position]['content'];
			if ($element_name === '&') {
				$position = $file->findNext(T_STRING, $position + 1, $end);
				if ($position) {
					$element_name = $file->getTokens()[$position]['content'];
				}
			}
		}

		return $element_name;
	}

	//------------------------------------------------------------------------------- getFunctionName
	/**
	 * Get the function name starting search from $start position.
	 * A function declaration is always followed by an opening bracket.
	 */
	public function getFunctionName(File $file, int $start) : string
	{
		return $this->getElementName($file, $start, T_CLOSE_CURLY_BRACKET);
	}

}
