<?php
namespace SitemapGenerator\Writer;

use SitemapGenerator\Exception\FileWriteException;
use SitemapGenerator\Exception\NotExistsException;
use SitemapGenerator\Exception\NotWritableException;

abstract class AbstractWriter implements WriterInterface
{
	/**
	 * @var string
	 */
	private $dirPath;

	public function __construct($dirPath)
	{
		$this->setDirPath($dirPath);
	}

	/**
	 * Set directory path, where files be saved
	 *
	 * @param string $dirPath
	 *
	 * @throws NotExistsException
	 * @throws NotWritableException
	 */
	public function setDirPath($dirPath)
	{
		if (!$this->checkDirExists($dirPath)) {
			throw new NotExistsException($dirPath, 'Target directory is not exists');
		}

		if ($this->checkDirWritable($dirPath)) {
			throw new NotWritableException($dirPath, 'Target directory exists, but not writable');
		}

		$this->dirPath = $dirPath;
	}

	/**
	 * Write sitemap content into file. Return path to target file.
	 *
	 * @param string $fileName
	 * @param string $content
	 *
	 * @return string
	 *
	 * @throws FileWriteException
	 * @throws NotWritableException
	 */
	final public function write($fileName, $content)
	{
		$filePath = rtrim($this->dirPath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
		$filePath .= ltrim(DIRECTORY_SEPARATOR, $fileName);

		if (!$this->checkFileWritable($filePath)) {
			throw new NotWritableException($filePath, 'Target file exists but not writable');
		}

		$isWrite = $this->writeContent($filePath, $content);

		if (!$isWrite) {
			throw new FileWriteException($filePath, $content, 'Target file is not write');
		}

		return $filePath;
	}

	/**
	 * Write content into file. Return true if file is recorded.
	 *
	 * @param string $filePath
	 * @param string $content
	 *
	 * @return boolean
	 */
	abstract public function writeContent($filePath, $content);

	/**
	 * Check if directory exists
	 *
	 * @param string $dirPath
	 *
	 * @return boolean
	 */
	protected function checkDirExists($dirPath)
	{
		return is_dir($dirPath);
	}

	/**
	 * Check if directory is writable
	 *
	 * @param string $dirPath
	 *
	 * @return boolean
	 */
	protected function checkDirWritable($dirPath)
	{
		return is_writable($dirPath);
	}

	/**
	 * Check if file exists and writable
	 *
	 * @param string $filePath
	 *
	 * @return boolean
	 */
	protected function checkFileWritable($filePath)
	{
		return (!is_file($filePath) || is_writable($filePath));
	}
}