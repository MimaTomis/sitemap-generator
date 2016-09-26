<?php
namespace SitemapGenerator\Generator;

use SitemapGenerator\Extractor\DataExtractorInterface;

interface GeneratorInterface
{
	/**
	 * Generate sitemap by file name and data extractor.
	 * Return path to generated file.
	 *
	 * @param string $fileName
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	public function generate($fileName, DataExtractorInterface $extractor);
}