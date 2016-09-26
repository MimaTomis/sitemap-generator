<?php
namespace SitemapGenerator\Generator;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Renderer\SitemapRendererInterface;
use SitemapGenerator\Writer\WriterInterface;

class SimpleGenerator implements GeneratorInterface
{
	/**
	 * @var WriterInterface
	 */
	private $writer;
	/**
	 * @var SitemapRendererInterface
	 */
	private $renderer;

	public function __construct(WriterInterface $writer, SitemapRendererInterface $renderer)
	{
		$this->writer = $writer;
		$this->renderer = $renderer;
	}

	/**
	 * Generate sitemap by file name and data extractor.
	 * Return path to generated file.
	 *
	 * @param string $fileName
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	public function generate($fileName, DataExtractorInterface $extractor)
	{
		$sitemap = $this->renderer->render($extractor);

		return $this->writer->write($fileName, $sitemap);
	}
}