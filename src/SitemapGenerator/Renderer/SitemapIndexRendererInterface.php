<?php
namespace SitemapGenerator\Renderer;

interface SitemapIndexRendererInterface
{
	/**
	 * Render and return sitemap index by given list of sitemap files
	 * Read the document: http://www.sitemaps.org/protocol.html#sitemapIndex_sitemapindex
	 *
	 * @param array $fileUrls
	 *
	 * @return string
	 */
	public function render(array $fileUrls);
}