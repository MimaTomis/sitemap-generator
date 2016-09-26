<?php
namespace SitemapGenerator\Renderer;

class SitemapIndexRenderer implements SitemapIndexRendererInterface
{
	/**
	 * Render and return sitemap index by given list of sitemap files
	 * Read the document: http://www.sitemaps.org/protocol.html#sitemapIndex_sitemapindex
	 *
	 * @param array $fileUrls
	 *
	 * @return string
	 */
	public function render(array $fileUrls)
	{
		$xml = '';
		$date = (new \DateTime())->format(\DateTime::ISO8601);

		foreach ($fileUrls as $file) {
			$xml .= $this->renderSitemapTag($file, $date);
		}

		return $this->renderSitemapIndexTag($xml);
	}

	/**
	 * Render sitemap tag by sitemap file URL and date modified.
	 *
	 * @param string $fileUrl
	 * @param string $lastModified
	 *
	 * @return string
	 */
	protected function renderSitemapTag($fileUrl, $lastModified)
	{
		$xml = '<sitemap>';

		$xml .= sprintf('<loc>%s</loc>', $fileUrl);
		$xml .= sprintf('<lastmod>%s</lastmod>', $lastModified);

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