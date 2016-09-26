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
	protected $directoryToSaveSitemap;

	public function __construct($directoryToSaveSitemap)
	{
		$this->setDirectoryToSaveSitemap($directoryToSaveSitemap);
	}

	/**
	 * Set directory path, where files be saved
	 *
	 * @param string $directoryToSaveSitemap
	 *
	 * @throws NotExistsException
	 * @throws NotWritableException
	 */
	public function setDirectoryToSaveSitemap($directoryToSaveSitemap)
	{
		if (!$this->checkDirExists($directoryToSaveSitemap)) {
			throw new NotExistsException($directoryToSaveSitemap, 'Target directory is not exists');
		}

		if (!$this->checkDirWritable($directoryToSaveSitemap)) {
			throw new NotWritableException($directoryToSaveSitemap, 'Target directory exists, but not writable');
		}

		$this->directoryToSaveSitemap = $directoryToSaveSitemap;
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
		$filePath = rtrim($this->directoryToSaveSitemap, DIRECTORY_SEPARATOR);
		$filePath .= DIRECTORY_SEPARATOR.ltrim($fileName, DIRECTORY_SEPARATOR);

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
	abstract protected function writeContent($filePath, $content);

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