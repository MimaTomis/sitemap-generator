<?php
namespace SitemapGenerator\Renderer;

use SitemapGenerator\Entity\SitemapItem;

class SitemapIndexRenderer implements SitemapIndexRendererInterface
{
	/**
	 * Render and return sitemap index by given list of sitemap items
	 * Read the document: http://www.sitemaps.org/protocol.html#sitemapIndex_sitemapindex
	 *
	 * @param SitemapItem[] $items
	 *
	 * @return string
	 */
	public function render(array $items)
	{
		$xml = '';

		foreach ($items as $item) {
			$xml .= $this->renderSitemapTag($item);
		}

		return $this->renderSitemapIndexTag($xml);
	}

	/**
	 * Render sitemap tag by sitemap file URL and date modified.
	 *
	 * @param SitemapItem $item
	 *
	 * @return string
	 */
	protected function renderSitemapTag(SitemapItem $item)
	{
		$xml = '<sitemap>';

		$xml .= sprintf('<loc>%s</loc>', $item->getLocation());

		if ($lastModified = $item->getLastModified()) {
			$xml .= sprintf('<lastmod>%s</lastmod>', $lastModified->format(\DateTime::ISO8601));
		}

   		return $xml .= '</sitemap>';
	}

	/**
	 * Render sitemapindex tag by string, contains list of sitemap tags
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	protected function renderSitemapIndexTag($content)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		$xml .= $content;

		return $xml .= '</sitemapindex>';
	}
}