<?php
namespace SitemapGenerator\Exception;

class NotWritableException extends SitemapGeneratorException
{
	/**
	 * @var string
	 */
	private $path;

	public function __construct($path, $message = '', $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
}