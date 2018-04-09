<?php
namespace ITRocks\Coding_Standard\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Sniffs\Sniff;
use ReflectionClass;
use ReflectionException;

/**
 * Class Sniff_TestCase
 */
abstract class Sniff_Test_Case extends \PHPUnit_Framework_TestCase
{

	//-------------------------------------------------------------------------------------- EXPECTED
	const EXPECTED = 'expected';

	//--------------------------------------------------------------------------------------- MESSAGE
	const MESSAGE = 'message';

	//----------------------------------------------------------------------------------------- SNIFF
	/**
	 * Class of the sniff to test.
	 *
	 * @var Sniff
	 */
	const SNIFF = '';

	//---------------------------------------------------------------------------------------- SOURCE
	const SOURCE = 'source';

	//---------------------------------------------------------------------------------- $tested_file
	/**
	 * The PHP_CodeSniffer_File object containing parsed contents of the test case file.
	 *
	 * @var \PHP_CodeSniffer\Files\File
	 */
	public static $tested_file;

	//------------------------------------------------------------------------ expectedErrorsProvider
	/**
	 * @return array
	 * @see testExpectedErrors
	 */
	public function expectedErrorsProvider()
	{
		$errors = [];
		foreach ($this->getExpectedErrors() as $line => $expected_error) {
			$errors['line ' . $line] = ['line' => $line, static::EXPECTED => $expected_error];
		}
		return $errors;
	}

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return array
	 * @see testExpectedErrors
	 */
	abstract public function getExpectedErrors();

	//------------------------------------------------------------------------------ setUpBeforeClass
	/**
	 * Initialize & tokenize \PHP_CodeSniffer\Files\File with code from the test case file.
	 * Methods used for these tests can be found in a test case file in the same
	 * directory and with the same name, using the .inc extension.
	 *
	 * @return void
	 * @throws ReflectionException
	 * @throws \PHP_CodeSniffer\Exceptions\RuntimeException
	 */
	public static function setUpBeforeClass()
	{
		$reflection_tester        = new ReflectionClass(static::class);
		$reflection_class_to_test = new ReflectionClass(static::SNIFF);
		$path_to_test_file        = dirname($reflection_tester->getFileName())
			. '/' . basename($reflection_tester->getFileName(), '.php')
			. '.inc';
		if (is_file($path_to_test_file)) {
			$config            = new Config();
			$config->standards = ['ITRocks'];

			$ruleset = new Ruleset($config);
			$ruleset->registerSniffs([$reflection_class_to_test->getFileName()], [], []);
			$ruleset->populateTokenListeners();
			static::$tested_file = new DummyFile(
				file_get_contents($path_to_test_file), $ruleset, $config
			);
			static::$tested_file->process();
		}
	}

	//---------------------------------------------------------------------------- testExpectedErrors
	/**
	 * Tests all expected errors
	 *
	 * @dataProvider expectedErrorsProvider
	 * @param $line            integer
	 * @param $expected_errors array
	 */
	public function testExpectedErrors($line, $expected_errors)
	{
		$this->assertArrayHaskey($line, static::$tested_file->getErrors());

		$errors = [];
		foreach (static::$tested_file->getErrors()[$line] as $colum_errors) {
			foreach ($colum_errors as $error) {
				$errors[] = [
					self::MESSAGE => $error[self::MESSAGE],
					self::SOURCE  => $error[self::SOURCE],
				];
			}
		}

		$this->assertEquals($expected_errors, $errors);
	}

	//------------------------------------------------------------------------ testOnlyExpectedErrors
	/**
	 * Exact match of keys (no errors missing or excess)
	 */
	public function testOnlyExpectedErrors()
	{
		$errors = [];
		foreach (static::$tested_file->getErrors() as $line => $line_errors) {
			if (!array_key_exists($line, $this->getExpectedErrors())) {
				foreach ($line_errors as $colum_errors) {
					foreach ($colum_errors as $error) {
						$errors[$line] = [
							self::MESSAGE => $error[self::MESSAGE],
							self::SOURCE  => $error[self::SOURCE],
						];
					}
				}
			}
		}
		$this->assertEquals([], $errors);
	}

}
