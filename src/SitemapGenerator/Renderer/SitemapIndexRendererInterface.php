<?php
namespace SitemapGenerator\Renderer;

use SitemapGenerator\Entity\SitemapItem;

interface SitemapIndexRendererInterface
{
	/**
	 * Render and return sitemap index by given list of sitemap items
	 * Read the document: http://www.sitemaps.org/protocol.html#sitemapIndex_sitemapindex
	 *
	 * @param SitemapItem[] $items
	 *
	 * @return string
	 */
	public function render(array $items);
}