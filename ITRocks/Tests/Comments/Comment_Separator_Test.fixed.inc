<?php
namespace ITRocks\Coding_Standard\Tests\Comments;

//------------------------------------------------------------------------------------- noSeparator
function noSeparator()
{

}

//--------------------------------------------------------------------------- noSeparatorWithPhpDoc
/**
 *
 */
function noSeparatorWithPhpDoc()
{

}

//---------------------------------------------------------------------------------- wrongSeparator
function wrongSeparator()
{

}

//------------------------------------------------------------------------ wrongSeparatorWithPhpDoc
/**
 *
 */
function wrongSeparatorWithPhpDoc()
{

}

class Dummy_Class
{
	//---------------------------------------------------------------------------------- $noSeparator
	public $noSeparator;

	//------------------------------------------------------------------------ $noSeparatorWithPhpDoc
	public $noSeparatorWithPhpDoc;

	//------------------------------------------------------------------------------- $wrongSeparator
	public $wrongSeparator;

	//--------------------------------------------------------------------- $wrongSeparatorWithPhpDoc
	/**
	 *
	 */
	public $wrongSeparatorWithPhpDoc;

	//----------------------------------------------------------------------------------- noSeparator
	function noSeparator()
	{

	}

	//------------------------------------------------------------------------- noSeparatorWithPhpDoc
	/**
	 *
	 */
	function noSeparatorWithPhpDoc()
	{

	}

	//-------------------------------------------------------------------------------- wrongSeparator
	function wrongSeparator()
	{

	}

	//---------------------------------------------------------------------- wrongSeparatorWithPhpDoc
	/**
	 *
	 */
	function wrongSeparatorWithPhpDoc()
	{

	}

}
