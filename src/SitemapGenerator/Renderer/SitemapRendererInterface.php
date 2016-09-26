<?php
namespace SitemapGenerator\Renderer;

use SitemapGenerator\Extractor\DataExtractorInterface;

interface SitemapRendererInterface
{
	/**
	 * Generate sitemap files by data, which return extractor
	 *
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	public function render(DataExtractorInterface $extractor);
}