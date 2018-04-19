<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

use ITRocks\Coding_Standard\Sniffs\Comments\Comment_Separator;
use ITRocks\Coding_Standard\Sniffs\Comments\Comment_Separator_Sniff;
use ITRocks\Coding_Standard\Tests\Error;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class CommentComment_Separator_Sniff_Test
 */
class Comment_Separator_Sniff_Test extends Sniff_Test_Case
{

	//------------------------------------------------------------------------------- COMMENT_INVALID
	const COMMENT_INVALID = 'Coding_Standard.Comments.Comment_Separator_.invalid';

	//------------------------------------------------------------------------------- COMMENT_MISSING
	const COMMENT_MISSING = 'Coding_Standard.Comments.Comment_Separator_.missing';

	//---------------------------------------------------------------------- PROPERTY_COMMENT_INVALID
	const PROPERTY_COMMENT_INVALID = 'Coding_Standard.Comments.Property_Comment_Separator_.invalid';

	//---------------------------------------------------------------------- PROPERTY_COMMENT_MISSING
	const PROPERTY_COMMENT_MISSING = 'Coding_Standard.Comments.Property_Comment_Separator_.missing';

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Comment_Separator_Sniff::class;

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			new Error(4, sprintf(Comment_Separator::$missing_message, 'function', 'noSeparator()'),
				self::COMMENT_MISSING),
			new Error(12, sprintf(Comment_Separator::$missing_message, 'function', 'noSeparatorWithPhpDoc()'),
				self::COMMENT_MISSING),
			new Error(18, sprintf(Comment_Separator::$invalid_message, 'function', 'wrongSeparator()'),
				self::COMMENT_INVALID),
			new Error(27, sprintf(Comment_Separator::$invalid_message, 'function', 'wrongSeparatorWithPhpDoc()'),
				self::COMMENT_INVALID),
			new Error(34, sprintf(Comment_Separator::$missing_message, 'property', '$noSeparator'),
				self::PROPERTY_COMMENT_MISSING),
			new Error(36, sprintf(Comment_Separator::$missing_message, 'property', '$noSeparatorWithPhpDoc'),
				self::PROPERTY_COMMENT_MISSING),
			new Error(39, sprintf(Comment_Separator::$invalid_message, 'property', '$wrongSeparator'),
				self::PROPERTY_COMMENT_INVALID),
			new Error(45, sprintf(Comment_Separator::$invalid_message, 'property', '$wrongSeparatorWithPhpDoc'),
				self::PROPERTY_COMMENT_INVALID),
			new Error(47, sprintf(Comment_Separator::$missing_message, 'function', 'noSeparator()'),
				self::COMMENT_MISSING),
			new Error(55, sprintf(Comment_Separator::$missing_message, 'function', 'noSeparatorWithPhpDoc()'),
				self::COMMENT_MISSING),
			new Error(61, sprintf(Comment_Separator::$invalid_message, 'function', 'wrongSeparator()'),
				self::COMMENT_INVALID),
			new Error(70, sprintf(Comment_Separator::$invalid_message, 'function', 'wrongSeparatorWithPhpDoc()'),
				self::COMMENT_INVALID),
		];
	}

}
