<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;

/**
 * Special behavior for class properties.
 */
class Property_Comment_Separator_Sniff extends Comment_Separator
{

	//--------------------------------------------------------------------------------------- process
	/**
	 * Makes sure all class properties have a comment separator.
	 *
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$scope  = $stack_ptr;

		while ($scope = $this->findNextClassProperty($file, $scope)) {
			$comment  = $this->findPreviousComment($file, $scope);
			$property = $file->getTokens()[$scope]['content'];

			if (empty($comment)) {
				$this->errorMissingComment($file, $scope, $property);
			}
			elseif ($comment != $this->getCommentSeparator($property)) {
				$this->errorInvalidComment($file, $scope, $property);
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
			T_TRAIT
		];
	}

}
