<?php
namespace ITRocks\Coding_Standard\Sniffs\Comments;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class Function_Comment_Sniff.
 */
class Function_Comment_Sniff implements Sniff
{
	//---------------------------------------------------------------------------- ERROR_MISSING_TYPE
	const ERROR_MISSING_TYPE = 'Missing type';

	//----------------------------------------------------------------------------------- ERROR_ORDER
	const ERROR_ORDER = 'AutoFixable : PHPdoc param must begin with the variable name followed by its type';

	//--------------------------------------------------------------------------------- ERROR_PATTERN
	const ERROR_PATTERN = '@param should be $property type comment';

	//------------------------------------------------------------------------------- ERROR_PRIMITIVE
	const ERROR_PRIMITIVE = 'AutoFixable : Incorrect primitive %s use %s';

	//------------------------------------------------------------------------------------ PRIMITIVES
	const PRIMITIVES = [
		//scalar
		'bool'     => 'boolean',
		'Bool'     => 'boolean',
		'Boolean'  => 'boolean',
		'int'      => 'integer',
		'Int'      => 'integer',
		'Integer'  => 'integer',
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
	/**
	 * @var  string
	 */
	public $comment;

	//------------------------------------------------------------------------------------- $property
	/**
	 * @var string
	 */
	public $property;

	//----------------------------------------------------------------------------------------- $type
	/**
	 * @var string
	 */
	public $type;

	//------------------------------------------------------------------------------------- fixPhpDoc
	public function fixPhpDoc(File $file, $stack_ptr, $fix)
	{
		if ($fix) {
			$file->fixer->replaceToken($stack_ptr + 2, $this->toPhpDoc());
		}
	}

	//------------------------------------------------------------------------------------ orderError
	/**
	 * @param $file      File
	 * @param $stack_ptr integer
	 */
	public function orderError(File $file, $stack_ptr)
	{
		$fix = $file->addFixableError(self::ERROR_ORDER, $stack_ptr + 2, 'Invalid');
		$this->fixPhpDoc($file, $stack_ptr, $fix);
	}

	//--------------------------------------------------------------------------------------- process
	/**
	 * {@inheritdoc}
	 */
	public function process(File $file, $stack_ptr)
	{
		$this->property = '';
		$this->type     = '';
		$this->comment  = '';
		if ($file->getTokens()[$stack_ptr]['content'] === '@param') {
			$phpdoc = $file->getTokens()[$stack_ptr + 2]['content'];
			$match  = preg_match(static::REGEX_PARAM, $phpdoc, $matches);
			if (!$match) {
				$file->addError(self::ERROR_PATTERN, $stack_ptr, 'Invalid');
			}
			else {
				$this->property = $matches[1];
				$this->type     = $matches[2];
				$this->comment  = $matches[3];

				if (!$this->type) {
					$file->addError(static::ERROR_MISSING_TYPE, $stack_ptr + 2, 'Invalid');
				}

				if (strstr($this->type, '$') !== false) {
					$cache          = $this->property;
					$this->property = $this->type;
					$this->type     = $cache;
					$this->orderError($file, $stack_ptr);
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
	public function register()
	{
		return [T_DOC_COMMENT_TAG];
	}

	//--------------------------------------------------------------------------- shortPrimitiveError
	/**
	 * @param $file      File
	 * @param $stack_ptr integer
	 */
	public function shortPrimitiveError(File $file, $stack_ptr)
	{
		$fix        = $file->addFixableError(self::ERROR_PRIMITIVE, $stack_ptr + 2, 'Invalid',
			[$this->type, static::PRIMITIVES[$this->type]]);
		$this->type = strtolower(static::PRIMITIVES[$this->type]);
		$this->fixPhpDoc($file, $stack_ptr, $fix);
	}

	//-------------------------------------------------------------------------------------- toPhpDoc
	/**
	 * @return string
	 */
	public function toPhpDoc()
	{
		$phpdoc = [];
		if ($this->property) {
			$phpdoc[] = $this->property;
		}
		if (!empty($this->type)) {
			$phpdoc[] = $this->type;
		}
		if (!empty($this->comment)) {
			$phpdoc[] = $this->comment;
		}
		return join(' ', $phpdoc);
	}

}
