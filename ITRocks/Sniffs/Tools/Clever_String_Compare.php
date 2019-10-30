<?php
namespace ITRocks\Coding_Standard\Sniffs\Tools;

/**
 * Class Clever_String_Sorter
 */
class Clever_String_Compare
{
	//------------------------------------------------------------------------------ CAMEL_CASE_REGEX
	const CAMEL_CASE_REGEX = "/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/";

	//------------------------------------------------------------------------------------- camelCase
	/**
	 * Orders camel case strings by comparing each word
	 *
	 * @param $string_a string
	 * @param $string_b string
	 * @return integer
	 * @see strings
	 */
	public static function camelCase($string_a, $string_b)
	{
		return static::strings(static::splitCamelCase($string_a), static::splitCamelCase($string_b));
	}

	//------------------------------------------------------------------------------------- snakeCase
	/**
	 * Orders snake case strings by comparing each word
	 *
	 * @param $string_a string
	 * @param $string_b string
	 * @return integer
	 * @see strings
	 */
	public static function snakeCase($string_a, $string_b)
	{
		return static::strings(explode('_', $string_a), explode('_', $string_b));
	}

	//-------------------------------------------------------------------------------- splitCamelCase
	/**
	 * Splits string among a camel Case pattern
	 *
	 * @param $string string
	 * @return array[]|false|string[]
	 */
	public static function splitCamelCase($string)
	{
		return preg_split(self::CAMEL_CASE_REGEX, $string);
	}

	//--------------------------------------------------------------------------------------- strings
	/**
	 * Compare to array of strings
	 *
	 * @param $strings_a string[]
	 * @param $strings_b string[]
	 * @return integer
	 * @see strcmp()
	 */
	public static function strings(array $strings_a, array $strings_b)
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
