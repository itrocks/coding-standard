<?php declare(strict_types=1);
namespace ITRocks\Coding_Standard\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHP_CodeSniffer\Files\DummyFile;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

abstract class Sniff_Test_Case extends TestCase
{

	//--------------------------------------------------------------------------------------- VERBOSE
	const VERBOSE = false;

	//--------------------------------------------------------------------------- $path_to_fixed_file
	private string $path_to_fixed_file;

	//---------------------------------------------------------------------------------- $tested_file
	/** The PHP_CodeSniffer_File object containing parsed contents of the test case file. */
	public File $tested_file;

	//------------------------------------------------------------------------------------- getErrors
	/** @return Error[] */
	public function getErrors() : array
	{
		$parsed_errors = [];
		foreach ($this->tested_file->getErrors() as $line => $line_errors) {
			foreach ($line_errors as $column_errors) {
				foreach ($column_errors as $error) {
					$parsed_errors[] = new Error($line, $error['message'], $error['source']);
				}
			}
		}
		return $parsed_errors;
	}

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * @return Error[]
	 * @see testExpectedErrors
	 */
	abstract public function getExpectedErrors() : array;

	//----------------------------------------------------------------------------------------- setUp
	/**
	 * Initialize & tokenize \PHP_CodeSniffer\Files\File with code from the test case file.
	 * Methods used for these tests can be found in a test case file in the same
	 * directory and with the same name, using the .inc extension.
	 *
	 * @return void
	 * @throws RuntimeException
	 */
	public function setUp() : void
	{
		$property = new ReflectionProperty(Config::class, 'overriddenDefaults');
		$property->setValue([]);

		$config            = new Config();
		$config->standards = [__DIR__ . '/../../ITRocks'];
		$ruleset           = new Ruleset($config);
		$ruleset->populateTokenListeners();

		$reflection_tester = new ReflectionClass(static::class);
		$path_to_test_file =
			dirname($reflection_tester->getFileName()) . '/' . basename($reflection_tester->getFileName(),
				'.php') . '.inc';
		if (!is_file($path_to_test_file)) {
			$this->fail('Missing test file ' . $path_to_test_file);
		}
		$this->tested_file = new DummyFile(file_get_contents($path_to_test_file), $ruleset, $config);
		$this->tested_file->path = $path_to_test_file;

		$this->path_to_fixed_file =
			dirname($reflection_tester->getFileName()) . '/' . basename($reflection_tester->getFileName(),
				'.php') . '.fixed.inc';
	}

	//------------------------------------------------------------------------------------ sortErrors
	/**
	 * @param Error[] $errors
	 * @return Error[]
	 */
	public static function sortErrors(array $errors) : array
	{
		usort($errors, function ($a, $b) {
			$r = $a->line - $b->line;
			if ($r === 0) {
				$r = strcmp($a->source, $b->source);
			}

			if ($r === 0) {
				$r = strcmp($a->message, $b->message);
			}
			return $r;
		});
		return $errors;
	}

	//----------------------------------------------------------------------------------- testAutoFix
	/** Tests auto fixed file. */
	public function testAutoFix() : void
	{
		if (!is_file($this->path_to_fixed_file)) {
			$this->markTestSkipped('Missing fixed file ' . $this->path_to_fixed_file);
		}
		$this->tested_file->process();
		$this->tested_file->fixer->fixFile();
		$diff = $this->tested_file->fixer->generateDiff($this->path_to_fixed_file);
		if(self::VERBOSE && $diff != ''){
			// Helper for debugging
			echo $this->tested_file->fixer->getContents();
		}
		$this->assertEquals('', $diff);
	}

	//------------------------------------------------------------------------------------ testErrors
	/** Tests all expected errors. */
	public function testErrors() : void
	{
		$this->tested_file->process();
		$errors   = static::sortErrors(static::getErrors());
		$expected = static::sortErrors($this->getExpectedErrors());
		array_unshift($errors,   $this->tested_file->path);
		array_unshift($expected, $this->tested_file->path);
		$this->assertEquals($expected, $errors);
	}

}
