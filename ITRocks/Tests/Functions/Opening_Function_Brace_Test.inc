<?php
namespace ITRocks\Coding_Standard\Tests\Formatting;

/**
 * This class define test cases for opening function brace coding standard validation
 */
class Foo
{
	//---------------------------------------------------------------------------------- case010basic
	/**
	 * Test case OK: opening brace should be on new line just after function declaration
	 */
	function case010basic()
	{

	}

	//---------------------------------------------------------------------------------- case011basic
	/**
	 * Test case KO: missing new line
	 */
	function case011basic(){

	}

	//---------------------------------------------------------------------------------- case012basic
	/**
	 * Test case KO: too much new lines
	 */
	function case012basic()

	{

	}

	//------------------------------------------------------------------------- case020someParameters
	/**
	 * Test case OK: one line declaration with parameter
	 */
	function case020someParameters($foobar1, $foobar2)
	{

	}

	//------------------------------------------------------------------------- case021someParameters
	/**
	 * Test case KO: missing new line
	 */
	function case021someParameters($foobar1, $foobar2) {

	}

	//------------------------------------------------------------------------- case022someParameters
	/**
	 * Test case KO: too much new lines
	 */
	function case022someParameters($foobar1, $foobar2)


	{

	}

	//--------------------------------------------------------------------- case030multipleParameters
	/**
	 * Test case OK: multiple line declaration
	 */
	function case030multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14
	) {

	}

	//--------------------------------------------------------------------- case031multipleParameters
	/**
	 * Test case KO: multiple line declaration, closing parenthesis should be on new line
	 */
	function case031multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14)  {

	}

	//--------------------------------------------------------------------- case032multipleParameters
	/**
	 * Test case KO: multiple line declaration, missing space
	 */
	function case032multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14
	){

	}

	//--------------------------------------------------------------------- case033multipleParameters
	/**
	 * Test case KO: multiple line declaration, too much space
	 */
	function case033multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14
	)  {

	}

	//--------------------------------------------------------------------- case034multipleParameters
	/**
	 * Test case KO: multiple line declaration, closing parenthesis and opening bracket should be
	 * on same line when no return type
	 */
	function case034multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14
	)
	{

	}

	//--------------------------------------------------------------------- case035multipleParameters
	/**
	 * Test case KO: multiple line declaration, closing parenthesis and opening bracket should be
	 * on same line when no return type
	 */
	function case035multipleParameters($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6,
		$foobar7, $foobar8, $foobar9, $foobar10, $foobar11, $foobar12, $foobar13, $foobar14
	)

	{

	}

	//-------------------------------------------------------------------- case040basicWithReturnType
	/**
	 * Test case OK: one line declaration with return type
	 */
	function case040basicWithReturnType() : string
	{

	}

	//-------------------------------------------------------------------- case041basicWithReturnType
	/**
	 * Test case KO: missing new line
	 */
	function case041basicWithReturnType() : string {

	}

	//-------------------------------------------------------------------- case042basicWithReturnType
	/**
	 * Test case KO: too much new line
	 */
	function case042basicWithReturnType() : string

	{

	}

	//-------------------------------------------------------------------- case043basicWithReturnType
	/**
	 * Test case KO: missing before space
	 */
	function case043basicWithReturnType(): string
	{

	}

	//-------------------------------------------------------------------- case044basicWithReturnType
	/**
	 * Test case KO: missing after space
	 */
	function case044basicWithReturnType() :string
	{

	}

	//-------------------------------------------------------------------- case050basicWithReturnType
	/**
	 * Test case OK: return type with ? syntax
	 */
	function case050basicWithReturnType() : ?string
	{

	}

	//-------------------------------------------------------------------- case060basicWithReturnType
	/**
	 * Test case OK: return type with | syntax
	 */
	function case060basicWithReturnType() : null|string|bool|C
	{

	}

	//-------------------------------------------------------------------- case061basicWithReturnType
	/**
	 * Test case KO: too much space
	 */
	function case061basicWithReturnType() :  null | string | bool | C
	{

	}

	//------------------------------------------------------------------- case070simpleWithReturnType
	/**
	 * Test case OK: one line declaration with parameter and return type
	 */
	function case070simpleWithReturnType($foobar1, $foobar2) : string
	{

	}

	//------------------------------------------------------------------ case080complexWithReturnType
	/**
	 * Test case OK: Opening brace on new line when multiple line and return type
	 */
	static public function case080complexWithReturnType(
		string $base_class, string $feature_name, string $suffix = 'Controller',
		string $extension = 'php', bool $class_form = true
	) : string
	{

	}

	//------------------------------------------------------------------ case081complexWithReturnType
	/**
	 * Test case OK
	 */
	static public function case081complexWithReturnType(
		string $base_class, string $feature_name, string $suffix = 'Controller',
		string $extension = 'php', bool $class_form = true
	) : string|null|C
	{

	}

	//------------------------------------------------------------------ case082complexWithReturnType
	/**
	 * Test case OK
	 */
	static public function case082complexWithReturnType(
		string $base_class, string $feature_name, string $suffix = 'Controller',
		string $extension = 'php', bool $class_form = true
	) : ?string
	{

	}

	//------------------------------------------------------------------ case083complexWithReturnType
	/**
	 * Test case KO: missing new line before open brace
	 */
	static public function case083complexWithReturnType(
		string $base_class, string $feature_name, string $suffix = 'Controller',
		string $extension = 'php', bool $class_form = true
	) : string {

	}

	//------------------------------------------------------------------ case084complexWithReturnType
	/**
	 * Test case KO: too much new line
	 */
	static public function case084complexWithReturnType(
		string $base_class, string $feature_name, string $suffix = 'Controller',
		string $extension = 'php', bool $class_form = true
	) : string

	{

	}

	//------------------------------------------------------------------ case090complexWithReturnType
	/**
	 * Test case OK: declaration with parameter on one line and return type on the next line
	 */
	function case090complexWithReturnType($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6)
		: string
	{

	}

	//------------------------------------------------------------------ case091complexWithReturnType
	/**
	 * Test case KO: missing new line
	 */
	function case091complexWithReturnType($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6)
		: string {

	}

	//------------------------------------------------------------------ case092complexWithReturnType
	/**
	 * Test case KO: missing indentation
	 */
	function case092complexWithReturnType($foobar1, $foobar2, $foobar3, $foobar4, $foobar5, $foobar6)
	: string
	{

	}

}

	//----------------------------------------------------------------------- case100externalFunction
/**
 * Test case OK: external function
 */
function case100externalFunction(string $base_class)
{

}

	//----------------------------------------------------------------------- case101externalFunction
/**
 * Test case OK: external function
 */
function case101externalFunction(string $base_class, string $feature_name) : ?string
{

}

	//----------------------------------------------------------------------- case102externalFunction
/**
 * Test case OK: external function
 */
function case102externalFunction(
	string $base_class, string $feature_name, string $suffix = 'Controller',
	string $extension = 'php', bool $class_form = true
) : ?string
{

}

	//----------------------------------------------------------------------- case103externalFunction
/**
 * Test case OK: external function
 */
function case103externalFunction(string $base_class, string $feature_name, string $suffix)
	: string|OtheClass
{

}

	//----------------------------------------------------------------------- case104externalFunction
/**
 * Test case KO: missing indentation
 */
function case104externalFunction(string $base_class, string $feature_name, string $suffix)
: string|OtheClass
{

}
