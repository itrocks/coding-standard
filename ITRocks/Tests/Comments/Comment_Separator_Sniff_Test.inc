<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

function noSeparator()
{

}

/**
 *
 */
function noSeparatorWithPhpDoc()
{

}

// ------------- barfoo
function wrongSeparator()
{

}

// ------------- barfoo
/**
 *
 */
function wrongSeparatorWithPhpDoc()
{

}

class Dummy_Class
{
	public $noSeparator;

	public $noSeparatorWithPhpDoc;

	// ------------- barfoo
	public $wrongSeparator;

	// ------------- barfoo
	/**
	 *
	 */
	public $wrongSeparatorWithPhpDoc;

	function noSeparator()
	{

	}

	/**
	 *
	 */
	function noSeparatorWithPhpDoc()
	{

	}

	// ------------- barfoo
	function wrongSeparator()
	{

	}

	// ------------- barfoo
	/**
	 *
	 */
	function wrongSeparatorWithPhpDoc()
	{

	}

}
