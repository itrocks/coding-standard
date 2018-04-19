<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Trait Comment_Separator.
 */
trait Comment_Separator
{
	//------------------------------------------------------------------------------------ $end_types
	protected $end_types = [T_SEMICOLON, T_CLOSE_CURLY_BRACKET, T_OPEN_CURLY_BRACKET];

	//------------------------------------------------------------------------------ $invalid_message
	public static $invalid_message = 'Comment separator for %s %s is invalid';

	//--------------------------------------------------------------------------------------- $length
	public $length = 94;

	//------------------------------------------------------------------------------ $missing_message
	public static $missing_message = 'Comment separator is missing for %s %s';

	//----------------------------------------------------------------------------------------- error
	/**
	 * Adds an error at the given position for the given element name.
	 * The type of element is guessed from tokens list.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @param $name       string  The name of the element.
	 * @param $error_type string  Type of the error (invalid or missing)
	 * @return array
	 */
	private function error(File $file, $stack_ptr, $name, $error_type)
	{
		$token = $file->getTokens()[$stack_ptr]['type'];
		$type  = substr(strtolower($token), 2);

		if ($type == 'function') {
			$name .= '()';
		}
		elseif ($type == 'variable') {
			$type = 'property';
		}

		switch ($error_type) {
			case 'invalid':
				$error_message = sprintf(static::$invalid_message, $type, $name);
				break;

			case 'missing':
				$error_message = sprintf(static::$missing_message, $type, $name);
				break;

			default:
				$error_message = 'Unknown error';
		}

		return [
			'type'    => $error_type,
			'message' => $error_message
		];
	}

	//--------------------------------------------------------------------------- errorInvalidComment
	/**
	 * Adds an invalid comment error for given element.
	 *
	 * @param $file        File    The current parsed file object.
	 * @param $stack_ptr   integer The current pointer position.
	 * @param $name        string  The name of the element.
	 * @param $comment_pos integer The position of the comment
	 */
	protected function errorInvalidComment(File $file, $stack_ptr, $name, $comment_pos)
	{
		$error = $this->error($file, $stack_ptr, $name, 'invalid');
		$fix   = $file->addFixableError($error['message'], $stack_ptr, $error['type']);
		if ($fix) {
			$file->fixer->replaceToken($comment_pos, $this->getCommentSeparator($name));
		}
	}

	//--------------------------------------------------------------------------- errorMissingComment
	/**
	 * Adds a missing comment error for given element.
	 *
	 * @param $file        File    The current parsed file object.
	 * @param $stack_ptr   integer The current pointer position.
	 * @param $name        string  The name of the element.
	 * @param $comment_pos integer The position of the comment
	 */
	protected function errorMissingComment(File $file, $stack_ptr, $name, $comment_pos)
	{
		$error = $this->error($file, $stack_ptr, $name, 'missing');
		$fix   = $file->addFixableError($error['message'], $stack_ptr, $error['type']);
		if ($fix) {
			$file->fixer->addContentBefore($comment_pos, $this->getCommentSeparator($name));
			$file->fixer->addNewlineBefore($comment_pos);
		}
	}

	//------------------------------------------------------------------------------------- findError
	/**
	 * @param $file      File
	 * @param $stack_ptr integer
	 * @param $name      string
	 */
	public function findError(File $file, $stack_ptr, $name)
	{
		$token_navigator = new Token_Navigator($file, $stack_ptr);
		$line            = $file->getTokens()[$stack_ptr]['line'];

		// Is there doc before
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
			$tokens = $token_navigator->getTokens($line, $line);
			$first  = array_keys($tokens)[0];
			$this->errorMissingComment($file, $stack_ptr, $name, $first);
		}
	}

	//--------------------------------------------------------------------------- findPreviousComment
	/**
	 * Tries to find the first previous comment.
	 * Returns its value if found, null otherwise.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @return null|integer
	 */
	protected function findPreviousComment(File $file, $stack_ptr)
	{
		$end         = $file->findPrevious($this->end_types, $stack_ptr);
		$comment_pos = $file->findPrevious(T_COMMENT, $stack_ptr, $end);
		$tokens      = $file->getTokens();

		if (!empty($comment_pos)) {
			if (substr($tokens[$comment_pos]['content'], 0, 2) == '//') {
				return $comment_pos;
			}
			elseif (substr($tokens[$comment_pos]['content'], 0, 2) == '/*') {
				return $this->findPreviousComment($file, $comment_pos - 1);
			}
		}

		return null;
	}

	//--------------------------------------------------------------------------- getCommentSeparator
	/**
	 * Generates a comment separator for the given name.
	 *
	 * @param $name string
	 * @return string
	 */
	public function getCommentSeparator($name)
	{
		return '//' . str_repeat('-', $this->length - strlen($name)) . ' ' . $name . chr(10);
	}

	//------------------------------------------------------------------------------- getConstantName
	/**
	 * Get the constant name starting search from $start position.
	 * A class constant declaration always ends by a semicolon.
	 *
	 * @param $file  File
	 * @param $start integer
	 * @return string
	 */
	public function getConstantName(File $file, $start)
	{
		return $this->getElementName($file, $start, T_SEMICOLON);
	}

	//-------------------------------------------------------------------------------- getElementName
	/**
	 * Get the name of an element starting search from $start.
	 *
	 * @param $file      File
	 * @param $start     integer
	 * @param $stop_type mixed The element type ending the declaration of the searched element.
	 * @return string
	 */
	private function getElementName(File $file, $start, $stop_type)
	{
		$element_name = '';
		$end          = $file->findNext($stop_type, $start);
		$position     = $file->findNext(T_STRING, $start, $end);

		if ($position) {
			$element_name = $file->getTokens()[$position]['content'];
		}

		return $element_name;

	}

	//------------------------------------------------------------------------------- getFunctionName
	/**
	 * Get the function name starting search from $start position.
	 * A function declaration is always followed by an opening bracket.
	 *
	 * @param $file  File
	 * @param $start integer
	 * @return string
	 */
	public function getFunctionName(File $file, $start)
	{
		return $this->getElementName($file, $start, T_CLOSE_CURLY_BRACKET);
	}

}
