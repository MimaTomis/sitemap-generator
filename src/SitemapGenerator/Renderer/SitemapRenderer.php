<?php
namespace SitemapGenerator\Renderer;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Entity\SitemapItem;

class SitemapRenderer implements SitemapRendererInterface
{
	/**
	 * Generate sitemap files by data, which return extractor.
	 *
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	public function render(DataExtractorInterface $extractor)
	{
		$xml = '';

		foreach ($extractor->extractData() as $item) {
			$xml .= $this->renderUrlTag($item);
		}

		return $this->renderUrlsetTag($xml);
	}

	/**
	 * Render url tag for sitemap.
	 * Read that document: http://www.sitemaps.org/ru/protocol.html#urldef
	 *
	 * @param SitemapItem $item
	 *
	 * @return string
	 */
	protected function renderUrlTag(SitemapItem $item)
	{
		$xml = '<url>';
		$xml .= sprintf('<loc>%s</loc>', $item->getLocation());

		if ($lastModified = $item->getLastModified()) {
			$xml .= sprintf('<lastmod>%s</lastmod>', $lastModified->format('Y-m-d'));
		}

		if ($changeFrequency = $item->getChangeFrequency()) {
			$xml .= sprintf('<changefreq>%s</changefreq>', $changeFrequency);
		}

		if ($priority = $item->getPriority()) {
			$xml .= sprintf('<priority>%.1f</priority>', $priority);
		}

		return $xml .= '</url>';
	}

	/**
	 * Render <xml> and <urlset> tag for sitemap.
	 * Read that document: http://www.sitemaps.org/ru/protocol.html#urlsetdef
	 *
	 * @param $content
	 *
	 * @return string
	 */
	protected function renderUrlsetTag($content)
	{
		return '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$content.'</urlset>';
	}
}