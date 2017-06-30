<?php
namespace ITRocks\Coding_Standard\Tests\Classes;

use ITRocks\Coding_Standard\Sniffs\Classes\Method_Order_Sniff;
use ITRocks\Coding_Standard\Tests\Sniff_Test_Case;

/**
 * Class Scope_Order_Sniff_Test
 */
class Method_Order_Sniff_Test extends Sniff_Test_Case
{

	//----------------------------------------------------------------------------------------- SNIFF
	const SNIFF = Method_Order_Sniff::class;

	//----------------------------------------------------------------------------- getExpectedErrors
	/**
	 * {@inheritdoc}
	 */
	public function getExpectedErrors()
	{
		return [
			19 => [
				[
					'source'  => 'Coding_Standard.Classes.Method_Order_.Invalid',
					'message' => 'Methods must be ordered alphabetically:'
						. ' method_02_misplaced() must declared before method_03().'
				]
			],
			20 => [
				[
					'source'  => 'Coding_Standard.Classes.Method_Order_.Invalid',
					'message' => 'Methods must be ordered alphabetically:'
						. ' method_03_misplaced() must declared before method_04().'
				]
			],
			21 => [
				[
					'source'  => 'Coding_Standard.Classes.Method_Order_.Invalid',
					'message' => 'Methods must be ordered alphabetically:'
						. ' method_043_misplaced() must declared before method_05().'
				]
			],
			22 => [
				[
					'source'  => 'Coding_Standard.Classes.Method_Order_.Invalid',
					'message' => 'Methods must be ordered alphabetically:'
						. ' method_04_misplaced() must declared before method_05().'
				]
			]
		];
	}

}
