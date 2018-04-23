<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes\Constant_Order;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * This sniff makes sure constants are ordered alphabetically inside groups.
 */
class Const_Order_Sniff implements Sniff
{

	//----------------------------------------------------------------------------------- ERR_MESSAGE
	/**
	 * Default error message.
	 */
	const ERR_MESSAGE = 'This %s must be declared before constant %s';

	//------------------------------------------------------------------------------------ checkOrder
	/**
	 * Check order of given elements and add an error if necessary. Stop at first error encountered.
	 *
	 * @param $elements Const_Object[] : A list of Const_Object to compare.
	 * @param $file     File           : The current parsed file.
	 * @param $type     string         : The type to use in error message (constant or group).
	 */
	private function checkOrder(array $elements, File $file, $type)
	{
		$previous_constant = '';

		foreach ($elements as $const_object) {
			if (Clever_String_Compare::snakeCase($const_object->name, $previous_constant) < 0) {
				$file->addError(self::ERR_MESSAGE, $const_object->stack_ptr, 'Invalid', [$type, $previous_constant]);
				break;
			}

			$previous_constant = $const_object->name;
		}

	}

	//----------------------------------------------------------------------- getFirstElementOfGroups
	/**
	 * Return an array composed of first element of each group in $groups.
	 *
	 * @param $groups array : A list of Const_Object[]
	 * @return Const_Object[]
	 */
	private function getFirstElementOfGroups(array $groups)
	{
		$elements = [];

		foreach ($groups as $group) {
			$elements[] = $group[0];
		}

		return $elements;
	}

	//-------------------------------------------------------------------------------- groupConstants
	/**
	 * Find all constants in the file and group them.
	 * Return an array of Const_Object collections.
	 *
	 * @param $file      File
	 * @param $stack_ptr integer
	 * @return array
	 */
	private function groupConstants(File $file, $stack_ptr)
	{
		$const_position = $file->findNext(T_CONST, $stack_ptr + 1);
		$group          = [];
		$groups         = [];
		$previous       = null;
		$tokens         = $file->getTokens();

		// Find all constants of the class and group them.
		while ($const_position) {
			$name = $tokens[$const_position + 2]['content'];
			$line = $tokens[$const_position]['line'];

			$constant = new Const_Object($name, $line, $const_position);

			if ($previous instanceof Const_Object && ($constant->line - 1 == $previous->line)) {
				$group[] = $constant;
			}
			// New group.
			else {
				// Save previous group if not empty before cleaning it up.
				if (!empty($group)) {
					$groups[] = $group;
				}
				$group = [$constant];
			}

			$previous = $constant;

			$const_position = $file->findNext(T_CONST, $const_position + 1);
		}

		if (!empty($group)) {
			$groups[] = $group;
		}

		return $groups;
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * Make sure class's constants are alphabetically ordered.
	 * Rules:
	 *   - blocks are a group of constants, separated by a blank line
	 *   - constants under a same block must be ordered alphabetically
	 *   - blocks must be ordered alphabetically, based on name of their first constant
	 *
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$groups = $this->groupConstants($file, $stack_ptr);

		// Check order inside each group.
		foreach ($groups as $group) {
			$this->checkOrder($group, $file, 'constant');
		}

		// Check order between all groups.
		$elements = $this->getFirstElementOfGroups($groups);
		$this->checkOrder($elements, $file, 'group of constants');
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register()
	{
		return [
			T_CLASS,
			T_INTERFACE,
		];
	}

}
