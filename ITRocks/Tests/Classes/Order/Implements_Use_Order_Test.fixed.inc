<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Another;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Bar;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Foo;

/**
 * Class Foo_Bar
 */
class Foo_Bar implements Another\Bar_Foo, Bar, Foo
{

}
