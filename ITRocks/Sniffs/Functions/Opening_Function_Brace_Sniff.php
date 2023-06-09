<?php
namespace ITRocks\Coding_Standard\Sniffs\Functions;

use ITRocks\Coding_Standard\Sniffs\Tools\Token_Navigator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Functions\OpeningFunctionBraceBsdAllmanSniff;

class Opening_Function_Brace_Sniff extends OpeningFunctionBraceBsdAllmanSniff
{

	//---------------------------------------------------------------------------------- ERROR_INDENT
	const ERROR_INDENT = 'AutoFixable : return type must be indented if directly on next line';

	//------------------------------------------------------------------------------- ERROR_SAME_LINE
	const ERROR_SAME_LINE = 'AutoFixable : Opening brace must be on the same line as closing parenthesis';

	//------------------------------------------------------------------------------ ERROR_SAME_LINE2
	const ERROR_SAME_LINE2 = 'AutoFixable : Opening brace must be on next line when having multiple line function definition with a return type' ;

	//------------------------------------------------------------------------------ ERROR_SAME_LINE3
	const ERROR_SAME_LINE3 = 'AutoFixable : Closing parenthesis must return to new line when having multiple line function definition';

	//--------------------------------------------------------------------------------- ERROR_SPACING
	const ERROR_SPACING = 'AutoFixable : There must be one single space between closing parenthesis and opening brace';

	//-------------------------------------------------------------------------------- ERROR_SPACING2
	const ERROR_SPACING2 = 'AutoFixable : There must be one single space between return type separator and return type';

	//-------------------------------------------------------------------------------- ERROR_SPACING3
	const ERROR_SPACING3 = 'AutoFixable : There must be one single space between closing parenthesis and return type separator';

	//-------------------------------------------------------------------------------- SPACES_PER_TAB
	const SPACES_PER_TAB = 4 ;

	//-------------------------------------------------------------------------- $anonymous_class_end
	protected int $anonymous_class_end = 0;

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		$tokens     = $file->getTokens();
		$token_code = $tokens[$stack_ptr]['code'];
		if ($token_code === T_ANON_CLASS) {
			$depth = 0;
			do {
				$stack_ptr ++;
				$token = $tokens[$stack_ptr] ?? false;
				if ($token === false) {
					return;
				}
				if ($token['content'] === '{') {
					$depth ++;
				}
				elseif ($token['content'] === '}') {
					$depth --;
					if (!$depth) {
						$this->anonymous_class_end = $stack_ptr;
						return;
					}
				}
			} while ($token);
			return;
		}
		elseif ($token_code === T_CLOSURE) {
			parent::process($file, $stack_ptr);
			return;
		}
		elseif ($stack_ptr < $this->anonymous_class_end) {
			return;
		}

		$token_navigator = new Token_Navigator($file, $stack_ptr);

		// Does not exist for function taking no parameters.
		if (isset($tokens[$stack_ptr]['scope_opener'])) {
			$brace_opener = $tokens[$stack_ptr]['scope_opener'];
		}

		$parenthesis_opener = $tokens[$stack_ptr]['parenthesis_opener'];
		$parenthesis_closer = $tokens[$stack_ptr]['parenthesis_closer'];

		if (isset($brace_opener)) {
			$return_type_separator = null ;
			for ($i = $parenthesis_closer + 1; $i < $brace_opener; $i++) {
				if($tokens[$i]['content'] == ':'){
					$return_type_separator = $i ;
					break;
				}
			}

			if ($return_type_separator) {
				// Spacing ") :"
				if (
					($tokens[$parenthesis_closer + 1]['type'] !== 'T_WHITESPACE')
					|| $tokens[$return_type_separator + 1]['length'] != 1
				) {
					$fix = $file->addFixableError(self::ERROR_SPACING3, $stack_ptr, 'Invalid');
					if ($fix) {
						for ($i = $parenthesis_closer + 1; $i < $return_type_separator; $i++) {
								$token_navigator->clean($i, $i);
						}
						$file->fixer->addContent($parenthesis_closer, ' ');
					}
				}
				elseif ($tokens[$parenthesis_closer + 1]['content'] == "\n") {
					// Check indent (one more than for function)
					$return_indent = 0 ;
					for ($i = $parenthesis_closer + 2 ; ; $i++) {
						if ($tokens[$i]['type'] === 'T_WHITESPACE') {
							$return_indent += $tokens[$i]['length'];
						}
						else {
							break;
						}
					}
					$function_indent = 0 ;
					for ($i = $stack_ptr - 1; ; $i--) {
						if ($tokens[$i]['content'] === "\n") {
							break ;
						}
						if ($tokens[$i]['type'] === 'T_WHITESPACE') {
							$function_indent += $tokens[$i]['length'];
						}
						else {
							$function_indent = 0 ;
						}
					}
					if (($return_indent - $function_indent) !== self::SPACES_PER_TAB) {
						$fix = $file->addFixableError(self::ERROR_INDENT, $stack_ptr, 'Invalid');
						if ($fix) {
							for ($i = $parenthesis_closer + 2; $i < $return_type_separator; $i++) {
								$token_navigator->clean($i, $i);
							}
							$padding_content = '' ;
							for ($return_indent = 0 ; $return_indent <= $function_indent; $return_indent += self::SPACES_PER_TAB) {
								$padding_content .= '    ';
							}
							$file->fixer->addContent($parenthesis_closer + 1, $padding_content);
						}
					}
				}

				// Spacing ": returntype"
				if (
					($tokens[$return_type_separator + 1]['type'] !== 'T_WHITESPACE')
					|| ($tokens[$return_type_separator + 1]['length'] !== 1)
				) {
					$fix = $file->addFixableError(
						self::ERROR_SPACING2, $return_type_separator + 1, 'Invalid'
					);
					if ($fix) {
						for ($i = $return_type_separator + 1; $i < $brace_opener - 2; $i++) {
							if ($tokens[$i]['type'] == "T_WHITESPACE" && $tokens[$i]['content'] != "\n") {
								$token_navigator->clean($i, $i);
							}
						}
						$file->fixer->addContent($return_type_separator, ' ');
					}
				}

				// Opening brace must be on next line when having a return type
				if ($tokens[$brace_opener]['line'] !== $tokens[$return_type_separator]['line'] + 1) {
					$fix = $file->addFixableError(self::ERROR_SAME_LINE2, $stack_ptr, 'Invalid');
					if ($fix) {
						// Clean spacing
						for ($i = $brace_opener - 1; ; $i--) {
							if ($tokens[$i]['type'] == "T_WHITESPACE") {
								$token_navigator->clean($i, $i);
							}
							else {
								break;
							}
						}
						// And go to next line
						$file->fixer->addNewlineBefore($brace_opener);
					}
				}
			}
			else {
				// No return type
				if ($tokens[$parenthesis_closer]['line'] !== $tokens[$parenthesis_opener]['line']) {
					// Multiple line function declaration
					// Closing parenthesis must return to new line
					if ($tokens[$parenthesis_closer - 1]['type'] !== 'T_WHITESPACE') {
						$fix = $file->addFixableError(self::ERROR_SAME_LINE3, $stack_ptr, 'Invalid');
						if ($fix) {
							$file->fixer->addNewlineBefore($parenthesis_closer);
						}
					}
					// Opening brace must be on the same line as closing parenthesis when no return type
					if ($tokens[$brace_opener]['line'] != $tokens[$parenthesis_closer]['line']) {
						$fix = $file->addFixableError(self::ERROR_SAME_LINE, $stack_ptr, 'Invalid');
						if ($fix) {
							$file->fixer->replaceToken($brace_opener, ' {');
							$token_navigator->clean($parenthesis_closer + 1, $brace_opener - 1);
						}
					}
					elseif ($brace_opener !== ($parenthesis_closer + 2)
						|| $tokens[($parenthesis_closer + 1)]['code'] != T_WHITESPACE
						|| $tokens[($parenthesis_closer + 1)]['length'] != 1
					) {
						$fix = $file->addFixableError(
							self::ERROR_SPACING, ($parenthesis_closer + 1), 'Invalid'
						);
						if ($fix) {
							$file->fixer->replaceToken($brace_opener, ' {');
							$token_navigator->clean($parenthesis_closer + 1, $brace_opener - 1);
						}
					}
				}
				else {
					// Single line function without return type
					parent::process($file, $stack_ptr);
				}
			}
		}
		else {
			// No brace opener
			parent::process($file, $stack_ptr);
		}
	}

	/**
	 * Registers the tokens that this sniff wants to listen for.
	 *
	 * @return int[]
	 */
	public function register()
	{
		return array_merge([T_ANON_CLASS], parent::register());
	}

}
