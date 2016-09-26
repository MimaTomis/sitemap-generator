<?php
namespace SitemapGenerator\Writer;

class SimpleWriter extends AbstractWriter
{
	/**
	 * Write content into file.  Return true if file is recorded.
	 *
	 * @param string $filePath
	 * @param string $content
	 *
	 * @return boolean
	 */
	protected function writeContent($filePath, $content)
	{
		return @file_put_contents($filePath, $content);
	}
}