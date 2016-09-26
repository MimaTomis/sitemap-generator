<?php
namespace SitemapGenerator\Exception;

class FileWriteException extends SitemapGeneratorException
{
	/**
	 * @var string
	 */
	private $path;
	/**
	 * @var string
	 */
	private $content;

	public function __construct($path, $content, $message = '', $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->path = $path;
		$this->content = $content;
	}

	/**
	 * Get path to target file
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
}