<?php
namespace ITRocks\Coding_Standard\Tests\Classes\Order;

use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Foo;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Bar;
use ITRocks\Coding_Standard\Tests\Classes\Order\Test_Interfaces\Another;

/**
 * Class Foo_Bar
 */
class Foo_Bar implements Foo, Bar, Another\Bar_Foo
{

}
