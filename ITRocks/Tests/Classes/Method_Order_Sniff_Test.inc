<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

class Foo
{
	function method_01() { }
	public function method_02() { }
	public function meThod_02_MisPlacedBis() { }
	protected function method_03() { }
	private function method_04() { }

	static public function method_05() { }
	static protected function method_06() { }
	static private function method_07() { }

	public static function method_08() { }
	protected static function method_09() { }
	private static function method_10() { }

	public static function method_02_misplaced() { }
	protected static function method_03_misplaced() { }
	private static function method_043_misplaced() { }
	private static function method_04_misplaced() { }

}
