<?php
namespace ITRocks\CodingStandard\Tests\Classes;

class Foo
{
	//-------------------------------------------------------------------------------------- method01
	function method01()
	{ }

	//-------------------------------------------------------------------------------------- method02
	public function method02()
	{ }

	//-------------------------------------------------------------------------- meThod02MisPlacedBis
	public function meThod02MisPlacedBis()
	{ }

	//-------------------------------------------------------------------------------------- method03
	protected function method03()
	{ }

	//-------------------------------------------------------------------------------------- method04
	private function method04()
	{ }

	//-------------------------------------------------------------------------------------- method05
	static public function method05()
	{ }

	//-------------------------------------------------------------------------------------- method06
	static protected function method06()
	{ }

	//-------------------------------------------------------------------------------------- method07
	static private function method07()
	{ }

	//-------------------------------------------------------------------------------------- method08
	public static function method08()
	{ }

	//-------------------------------------------------------------------------------------- method09
	protected static function method09()
	{ }

	//-------------------------------------------------------------------------------------- method10
	private static function method10()
	{ }

	//----------------------------------------------------------------------------- method02misplaced
	public static function method02misplaced()
	{ }

	//----------------------------------------------------------------------------- method03misplaced
	protected static function method03misplaced()
	{ }

	//---------------------------------------------------------------------------- method043misplaced
	private static function method043misplaced()
	{ }

	//----------------------------------------------------------------------------- method04misplaced
	private static function method04misplaced()
	{ }

}
