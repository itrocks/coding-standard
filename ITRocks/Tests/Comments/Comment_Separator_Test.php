<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Comment_Separator;
use ITRocks\Coding_Standard\Sniffs\Comments\Comment_Separator_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * @see Comment_Separator_Sniff
 */
class Comment_Separator_Test extends Sniff_Test_Case
{
	// Use the trait to be able to test its methods.
	use Comment_Separator;

	//------------------------------------------------------------------------------- COMMENT_INVALID
	const COMMENT_INVALID = 'Coding_Standard.Comments.Comment_Separator_.Invalid';

	//------------------------------------------------------------------------------- COMMENT_MISSING
	const COMMENT_MISSING = 'Coding_Standard.Comments.Comment_Separator_.Missing';

	//---------------------------------------------------------------------- PROPERTY_COMMENT_INVALID
	const PROPERTY_COMMENT_INVALID = 'Coding_Standard.Comments.Property_Comment_Separator_.Invalid';

	//---------------------------------------------------------------------- PROPERTY_COMMENT_MISSING
	const PROPERTY_COMMENT_MISSING = 'Coding_Standard.Comments.Property_Comment_Separator_.Missing';

	//----------------------------------------------------------------------------- getExpectedErrors
	/** {@inheritdoc} */
	public function getExpectedErrors() : array
	{
		return [
			new Error(4, sprintf(self::$messages['Missing'], 'function', 'noSeparator()'),
				self::COMMENT_MISSING),
			new Error(12, sprintf(self::$messages['Missing'], 'function', 'noSeparatorWithPhpDoc()'),
				self::COMMENT_MISSING),
			new Error(18, sprintf(self::$messages['Invalid'], 'function', 'wrongSeparator()'),
				self::COMMENT_INVALID),
			new Error(27, sprintf(self::$messages['Invalid'], 'function', 'wrongSeparatorWithPhpDoc()'),
				self::COMMENT_INVALID),
			new Error(34, sprintf(self::$messages['Missing'], 'property', '$noSeparator'),
				self::PROPERTY_COMMENT_MISSING),
			new Error(36, sprintf(self::$messages['Missing'], 'property', '$noSeparatorWithPhpDoc'),
				self::PROPERTY_COMMENT_MISSING),
			new Error(39, sprintf(self::$messages['Invalid'], 'property', '$wrongSeparator'),
				self::PROPERTY_COMMENT_INVALID),
			new Error(45, sprintf(self::$messages['Invalid'], 'property', '$wrongSeparatorWithPhpDoc'),
				self::PROPERTY_COMMENT_INVALID),
			new Error(47, sprintf(self::$messages['Missing'], 'function', 'noSeparator()'),
				self::COMMENT_MISSING),
			new Error(55, sprintf(self::$messages['Missing'], 'function', 'noSeparatorWithPhpDoc()'),
				self::COMMENT_MISSING),
			new Error(61, sprintf(self::$messages['Invalid'], 'function', 'wrongSeparator()'),
				self::COMMENT_INVALID),
			new Error(70, sprintf(self::$messages['Invalid'], 'function', 'wrongSeparatorWithPhpDoc()'),
				self::COMMENT_INVALID),
		];
	}

	//---------------------------------------------------------------------------------- nameProvider
	/**
	 * Provides test data for testGetCommentSeparator().
	 *
	 * @return array<array{string,string}>
	 */
	public function nameProvider() : array
	{
		return [
			['foo', '//' . str_repeat('-', 91) . " foo\n"],
			['fooBar', '//' . str_repeat('-', 88) . " fooBar\n"],
			['foo bar', '//' . str_repeat('-', 87) . " foo bar\n"],
			['very long string', '//' . str_repeat('-', 78) . " very long string\n"],
		];
	}

	//----------------------------------------------------------------------- testGetCommentSeparator
	/**
	 * Tests Comment_Separator::getCommentSeparator() with several test parameters.
	 *
	 * @dataProvider nameProvider
	 */
	public function testGetCommentSeparator(string $name, string $expected) : void
	{
		$actual = $this->getCommentSeparator($name);
		$this->assertEquals($expected, $actual);
	}

}
