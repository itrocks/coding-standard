<?php
namespace ITRocks\Coding_Standard\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Sniffs\Sniff;
use ReflectionClass;

/**
 * Class Sniff_TestCase
 */
abstract class Sniff_Test_Case extends \PHPUnit_Framework_TestCase
{

	//----------------------------------------------------------------------------------------- SNIFF
	/**
	 * Class of the sniff to test.
	 *
	 * @var Sniff
	 */
	const SNIFF = '';

	//---------------------------------------------------------------------------------- $tested_file
	/**
	 * The PHP_CodeSniffer_File object containing parsed contents of the test case file.
	 *
	 * @var \PHP_CodeSniffer\Files\File
	 */
	public static $tested_file;

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return array
	 */
	abstract public function getExpectedErrors();

	//------------------------------------------------------------------------------ setUpBeforeClass
	/**
	 * Initialize & tokenize \PHP_CodeSniffer\Files\File with code from the test case file.
	 * Methods used for these tests can be found in a test case file in the same
	 * directory and with the same name, using the .inc extension.
	 *
	 * @return void
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

	//------------------------------------------------------------------------------------- testError
	/**
	 * Test error after process
	 */
	public function testError()
	{
		$errors = [];
		foreach (static::$tested_file->getErrors() as $line => $line_errors) {
			$errors[$line] = [];
			foreach ($line_errors as $colum_errors) {
				foreach ($colum_errors as $error) {
					$errors[$line][] = [
						'message' => $error['message'],
						'source'  => $error['source'],
					];
				}
			}
		}
		$this->assertEquals($this->getExpectedErrors(), $errors);
	}

}
