<?php
namespace ITRocks\Coding_Standard\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff as SniffInterface;

/**
 * Class Sniff.
 */
abstract class Sniff implements SniffInterface
{

	//------------------------------------------------------------------------------ $property_tokens
	/**
	 * List of tokens that can be used to define a class property.
	 *
	 * @var array
	 */
	protected $property_tokens = [
		T_PRIVATE,
		T_PROTECTED,
		T_PUBLIC,
		T_STATIC,
	];

	//------------------------------------------------------------------------- findNextClassProperty
	/**
	 * Tries to find the next class property.
	 *
	 * Returns its scope number if found, null otherwise.
	 *
	 * @param $file File     : The file object being sniffed.
	 * @param $start integer : The scope to start search from.
	 *
	 * @return int|null
	 */
	public function findNextClassProperty(File $file, $start)
	{
		$scope    = $file->findNext($this->property_tokens, $start);
		$tokens   = $file->getTokens();
		$property = null;

		if (isset($tokens[$scope + 2]) && $tokens[$scope + 2]['code'] == T_VARIABLE) {
			$property = $scope + 2;
		}
		elseif (isset($tokens[$scope + 4]) && $tokens[$scope + 4]['code'] == T_VARIABLE) {
			$property = $scope + 4;
		}

		return $property;
	}

}
