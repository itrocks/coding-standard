<?php
namespace ITRocks\Coding_Standard\Sniffs\Tools;

class Clever_String_Compare
{

	//------------------------------------------------------------------------------ CAMEL_CASE_REGEX
	const CAMEL_CASE_REGEX = "/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/";

	//------------------------------------------------------------------------------------- camelCase
	/**
	 * Orders camel case strings by comparing each word
	 *
	 * @see strings
	 */
	public static function camelCase(string $string_a, string $string_b) : int
	{
		return static::strings(static::splitCamelCase($string_a), static::splitCamelCase($string_b));
	}

	//------------------------------------------------------------------------------------- snakeCase
	/**
	 * Orders snake case strings by comparing each word
	 *
	 * @see strings
	 */
	public static function snakeCase(string $string_a, string $string_b) : int
	{
		return static::strings(explode('_', $string_a), explode('_', $string_b));
	}

	//-------------------------------------------------------------------------------- splitCamelCase
	/**
	 * Splits string among a camel Case pattern
	 *
	 * @return array[]|false|string[]
	 */
	public static function splitCamelCase(string $string) : array|false
	{
		return preg_split(self::CAMEL_CASE_REGEX, $string);
	}

	//--------------------------------------------------------------------------------------- strings
	/**
	 * Compare to array of strings
	 *
	 * @param string[] $strings_a
	 * @param string[] $strings_b
	 * @see strcmp
	 */
	public static function strings(array $strings_a, array $strings_b) : int
	{
		$strings_a = array_values($strings_a);
		$strings_b = array_values($strings_b);
		if (count($strings_a) === 0) {
			return count($strings_b) === 0 ? 0 : -1;
		}
		if (count($strings_b) === 0) {
			return 1;
		}
		$string_a = array_splice($strings_a, 0, 1)[0];
		$string_b = array_splice($strings_b, 0, 1)[0];
		$result   = strcmp($string_a, $string_b);
		if ($result < 0) {
			$result = -1;
		}
		if ($result > 0) {
			$result = 1;
		}
		return $result === 0 ? static::strings($strings_a, $strings_b) : $result;
	}

}
