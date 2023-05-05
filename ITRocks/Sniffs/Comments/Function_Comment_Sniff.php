<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class Function_Comment_Sniff implements Sniff
{

	//------------------------------------------------------------------------ ERROR_MISSING_PROPERTY
	const ERROR_MISSING_PROPERTY = 'Missing property';

	//---------------------------------------------------------------------------- ERROR_MISSING_TYPE
	const ERROR_MISSING_TYPE = 'Missing type';

	//----------------------------------------------------------------------------------- ERROR_ORDER
	const ERROR_ORDER = 'AutoFixable : PHPdoc param must begin with the type followed by the variable name';

	//--------------------------------------------------------------------------------- ERROR_PATTERN
	const ERROR_PATTERN = '@param should be type $property comment';

	//------------------------------------------------------------------------------- ERROR_PRIMITIVE
	const ERROR_PRIMITIVE = 'AutoFixable : Incorrect primitive %s use %s';

	//------------------------------------------------------------------------------------ PRIMITIVES
	const PRIMITIVES = [
		//scalar
		'boolean'  => 'bool',
		'Bool'     => 'bool',
		'Boolean'  => 'bool',
		'integer'  => 'int',
		'Int'      => 'int',
		'Integer'  => 'int',
		'Float'    => 'float',
		'String'   => 'string',
		// compound
		'Array'    => 'array',
		'Object'   => 'object',
		'Callable' => 'callable',
		'Iterable' => 'iterable',
	];

	//----------------------------------------------------------------------------------- REGEX_PARAM
	const REGEX_PARAM = '/(\\S+)(?:\\s+(\\S+))?(.*)?/';

	//------------------------------------------------------------------------------ REGEX_VAR_RETURN
	const REGEX_VAR_RETURN = '/(\\S+)?(.*)?/';

	//-------------------------------------------------------------------------------------- $comment
	public string $comment;

	//------------------------------------------------------------------------------------- $property
	public string $property;

	//----------------------------------------------------------------------------------------- $type
	public string $type;

	//------------------------------------------------------------------------------------- fixPhpDoc
	public function fixPhpDoc(File $file, int $stack_ptr, bool $fix) : void
	{
		if ($fix) {
			$file->fixer->replaceToken($stack_ptr + 2, $this->toPhpDoc());
		}
	}

	//------------------------------------------------------------------------------------ orderError
	public function orderError(File $file, int $stack_ptr) : void
	{
		$fix = $file->addFixableError(self::ERROR_ORDER, $stack_ptr + 2, 'Invalid');
		$this->fixPhpDoc($file, $stack_ptr, $fix);
	}

	//--------------------------------------------------------------------------------------- process
	/** {@inheritdoc} */
	public function process(File $file, $stack_ptr) : void
	{
		$this->type     = '';
		$this->property = '';
		$this->comment  = '';
		if ($file->getTokens()[$stack_ptr]['content'] === '@param') {
			$phpdoc = $file->getTokens()[$stack_ptr + 2]['content'];
			$match  = preg_match(static::REGEX_PARAM, $phpdoc, $matches);
			if (!$match) {
				$file->addError(self::ERROR_PATTERN, $stack_ptr, 'Invalid');
			}
			else {
				$this->type     = $matches[1];
				$this->property = $matches[2];
				$this->comment  = $matches[3];

				if (str_starts_with($this->type, '$')) {
					if (!$this->property) {
						$file->addError(static::ERROR_MISSING_TYPE, $stack_ptr + 2, 'Invalid');
					}
					else {
						$cache          = $this->property;
						$this->property = $this->type;
						$this->type     = $cache;
						$this->orderError($file, $stack_ptr);
					}
				}
				elseif (!str_starts_with($this->property, '$')) {
					$file->addError(static::ERROR_MISSING_PROPERTY, $stack_ptr + 2, 'Invalid');
				}

				if (array_key_exists($this->type, static::PRIMITIVES)) {
					$this->shortPrimitiveError($file, $stack_ptr);
				}
			}
		}

		if ($file->getTokens()[$stack_ptr]['content'] === '@var' || $file->getTokens()[$stack_ptr]['content'] === '@return') {
			$phpdoc = $file->getTokens()[$stack_ptr + 2]['content'];
			preg_match(static::REGEX_VAR_RETURN, $phpdoc, $matches);
			$this->type    = $matches[1];
			$this->comment = $matches[2];

			if (!$this->type) {
				$file->addError(static::ERROR_MISSING_TYPE, $stack_ptr, 'Invalid');
			}

			if (array_key_exists($this->type, static::PRIMITIVES)) {
				$this->shortPrimitiveError($file, $stack_ptr);
			}
		}
	}

	//-------------------------------------------------------------------------------------- register
	/**
	 * @codeCoverageIgnore
	 * {@inheritdoc}
	 */
	public function register() : array
	{
		return [T_DOC_COMMENT_TAG];
	}

	//--------------------------------------------------------------------------- shortPrimitiveError
	public function shortPrimitiveError(File $file, int $stack_ptr) : void
	{
		$fix = $file->addFixableError(self::ERROR_PRIMITIVE, $stack_ptr + 2, 'Invalid',
			[$this->type, static::PRIMITIVES[$this->type]]);
		$this->type = strtolower(static::PRIMITIVES[$this->type]);
		$this->fixPhpDoc($file, $stack_ptr, $fix);
	}

	//-------------------------------------------------------------------------------------- toPhpDoc
	public function toPhpDoc() : string
	{
		$phpdoc = [];
		if (!empty($this->type)) {
			$phpdoc[] = $this->type;
		}
		if ($this->property) {
			$phpdoc[] = $this->property;
		}
		if (!empty($this->comment)) {
			$phpdoc[] = trim($this->comment);
		}
		return join(' ', $phpdoc);
	}

}
