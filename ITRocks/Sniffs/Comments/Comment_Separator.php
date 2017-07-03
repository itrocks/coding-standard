<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use ITRocks\Coding_Standard\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Class Comment_Separator.
 */
abstract class Comment_Separator extends Sniff
{

	//------------------------------------------------------------------------------- INVALID_MESSAGE
	const INVALID_MESSAGE = 'Comment separator for %s %s is invalid';

	//---------------------------------------------------------------------------------------- LENGTH
	const LENGTH = 94;

	//------------------------------------------------------------------------------- MISSING_MESSAGE
	const MISSING_MESSAGE = 'Comment separator is missing for %s %s';

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
				$error_message = sprintf(self::INVALID_MESSAGE, $type, $name);
				break;

			case 'missing':
				$error_message = sprintf(self::MISSING_MESSAGE, $type, $name);
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
	 *
	 * @return null|string
	 */
	protected function findPreviousComment(File $file, $stack_ptr)
	{
		$end     = $file->findPrevious($this->types, $stack_ptr);
		$comment = $file->findPrevious(T_COMMENT, $stack_ptr, $end);

		if (!empty($comment)) {
			return $file->getTokens()[$comment]['content'];
		}

		return null;
	}

	//--------------------------------------------------------------------------- getCommentSeparator
	/**
	 * Generates a comment separator for the given name.
	 *
	 * @param $name string
	 *
	 * @return string
	 */
	public static function getCommentSeparator($name)
	{
		return '//' . str_repeat('-', self::LENGTH - strlen($name)) . ' ' . $name . chr(10);
	}

}
