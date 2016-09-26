<?php
namespace SitemapGenerator\Writer;

interface WriterInterface
{
	/**
	 * Set directory path, where files be saved
	 *
	 * @param string $directoryToSaveSitemap
	 */
	public function setDirectoryToSaveSitemap($directoryToSaveSitemap);

	/**
	 * Write sitemap content into file. Return path to target file.
	 *
	 * @param string $fileName
	 * @param string $content
	 *
	 * @return string
	 */
	public function write($fileName, $content);
}