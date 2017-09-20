<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;

/**
 * Trait Comment_Separator.
 */
trait Comment_Separator
{
	//------------------------------------------------------------------------------ $invalid_message
	public $invalid_message = 'Comment separator for %s %s is invalid';

	//--------------------------------------------------------------------------------------- $length
	public $length = 94;

	//------------------------------------------------------------------------------ $missing_message
	public $missing_message = 'Comment separator is missing for %s %s';

	//---------------------------------------------------------------------------------------- $types
	protected $types = [T_SEMICOLON, T_CLOSE_CURLY_BRACKET, T_OPEN_CURLY_BRACKET];

	//----------------------------------------------------------------------------------------- error
	/**
	 * Adds an error at the given position for the given element name.
	 * The type of element is guessed from tokens list.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @param $name       string  The name of the element.
	 * @param $error_type string  Type of the error (invalid or missing)
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
				$error_message = sprintf($this->invalid_message, $type, $name);
				break;

			case 'missing':
				$error_message = sprintf($this->missing_message, $type, $name);
				break;

			default:
				$error_message = 'Unknown error';
		}

		$file->addError($error_message, $stack_ptr, $error_type);
	}

	//--------------------------------------------------------------------------- errorInvalidComment
	/**
	 * Adds an invalid comment error for given element.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @param $name       string  The name of the element.
	 */
	protected function errorInvalidComment(File $file, $stack_ptr, $name)
	{
		$this->error($file, $stack_ptr, $name, 'invalid');
	}

	//--------------------------------------------------------------------------- errorMissingComment
	/**
	 * Adds a missing comment error for given element.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @param $name       string  The name of the element.
	 */
	protected function errorMissingComment(File $file, $stack_ptr, $name)
	{
		$this->error($file, $stack_ptr, $name, 'missing');
	}

	//--------------------------------------------------------------------------- findPreviousComment
	/**
	 * Tries to find the first previous comment.
	 * Returns its value if found, null otherwise.
	 *
	 * @param $file       File    The current parsed file object.
	 * @param $stack_ptr  integer The current pointer position.
	 * @return null|string
	 */
	protected function findPreviousComment(File $file, $stack_ptr)
	{
		$end     = $file->findPrevious($this->types, $stack_ptr);
		$comment = $file->findPrevious(T_COMMENT, $stack_ptr, $end);
		$tokens  = $file->getTokens();

		if (!empty($comment)) {
			if (substr($tokens[$comment]['content'], 0, 2) == '//') {
				return $tokens[$comment]['content'];
			}
			elseif (substr($tokens[$comment]['content'], 0, 2) == '/*') {
				return $this->findPreviousComment($file, $comment-1);
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
		$end           = $file->findNext($stop_type, $start);
		$position      = $file->findNext(T_STRING, $start, $end);

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
