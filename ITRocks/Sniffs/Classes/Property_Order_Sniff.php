<?php
namespace ITRocks\Coding_Standard\Sniffs\Classes;

use ITRocks\Coding_Standard\Sniffs\Tools\Clever_String_Compare;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure class properties are ordered alphabetically.
 */
class Property_Order_Sniff implements Sniff
{

	//-------------------------------------------------------------------------- ERROR_PROPERTY_ORDER
	const ERROR_PROPERTY_ORDER = 'Property %s must be declared before %s';

	//--------------------------------------------------------------------------------------- $braces
	protected int $braces = 0;

	//-------------------------------------------------------------------------------------- $classes
	protected array $classes = [];

	//-------------------------------------------------------------------------------- $next_variable
	protected bool $next_variable = false;

	//----------------------------------------------------------------------------------- $properties
	protected array $properties = [];

	//--------------------------------------------------------------------------------------- process
	public function process(File $file, $stack_ptr) : void
	{
		$tokens = $file->getTokens();
		$token  = $tokens[$stack_ptr];
		$code   = $token['code'];
		switch ($code) {
			case T_ANON_CLASS:
			case T_CLASS:
				$this->classes[$this->braces] = $token;
				$this->next_variable = false;
				break;
			case T_CLOSE_CURLY_BRACKET:
				unset($this->properties[$this->braces]);
				$this->braces --;
				unset($this->classes[$this->braces]);
				break;
			case T_CLOSURE:
			case T_CONST:
			case T_FUNCTION:
				$this->next_variable = false;
				break;
			case T_OPEN_CURLY_BRACKET:
				$this->braces ++;
				break;
			case T_PRIVATE:
			case T_PROTECTED:
			case T_PUBLIC:
			case T_VAR:
				if (array_key_last($this->classes) === ($this->braces - 1)) {
					$this->next_variable = true;
				}
				break;
			case T_VARIABLE:
				if ($this->next_variable) {
					$this->next_variable = false;
					$this->processMemberVar($file, $stack_ptr);
				}
				break;
		}
	}

	//------------------------------------------------------------------------------ processMemberVar
	protected function processMemberVar(File $file, int $stack_ptr) : void
	{
		$tokens = $file->getTokens();
		if (in_array($tokens[$stack_ptr]['code'], [T_ANON_CLASS, T_CLASS], true)) {
			return;
		}
		$property = $tokens[$stack_ptr]['content'];

		// Append property name in list.
		$this->properties[$this->braces][] = $property;
		$properties =& $this->properties[$this->braces];
		$i = array_key_last($properties);

		// Check if previous property is alphabetically ordered.
		if ($i && (Clever_String_Compare::snakeCase($properties[$i - 1], $property) > 0)) {
			$previous_property = $properties[$i - 1];
			$file->addError(
				self::ERROR_PROPERTY_ORDER, $stack_ptr, 'Invalid', [$property, $previous_property]
			);
		}
	}

	//-------------------------------------------------------------------------------------- register
	public function register() : array
	{
		return [
			T_ANON_CLASS,
			T_CLASS,
			T_CLOSURE,
			T_CLOSE_CURLY_BRACKET,
			T_CONST,
			T_FUNCTION,
			T_OPEN_CURLY_BRACKET,
			T_PRIVATE,
			T_PROTECTED,
			T_PUBLIC,
			T_VAR,
			T_VARIABLE
		];
	}

}
