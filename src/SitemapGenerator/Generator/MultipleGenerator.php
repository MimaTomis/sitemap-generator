<?php
namespace SitemapGenerator\Generator;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Extractor\PartialDataExtractor;
use SitemapGenerator\Renderer\SitemapIndexRendererInterface;
use SitemapGenerator\Writer\WriterInterface;

class MultipleGenerator implements GeneratorInterface
{
	/**
	 * @var WriterInterface
	 */
	protected $writer;
	/**
	 * @var GeneratorInterface
	 */
	protected $generator;
	/**
	 * @var SitemapIndexRendererInterface
	 */
	protected $indexRenderer;
	/**
	 * @var int
	 */
	protected $limitOfSitemapRecords = 10000;
	/**
	 * @var string
	 */
	protected $urlToSitemapDirectory;

	public function __construct(WriterInterface $writer, GeneratorInterface $generator, SitemapIndexRendererInterface $indexRenderer)
	{
		$this->writer = $writer;
		$this->generator = $generator;
		$this->indexRenderer = $indexRenderer;
	}

	/**
	 * Set limit of records in one sitemap file
	 *
	 * @param int $limit
	 */
	public function setLimitOfSitemapRecords($limit)
	{
		$this->limitOfSitemapRecords = $limit;
	}

	/**
	 * Set absolute url to directory, where sitemap files if saving
	 *
	 * @param string $urlToSitemapDirectory
	 */
	public function setUrlToSitemapDirectory($urlToSitemapDirectory)
	{
		$this->urlToSitemapDirectory = rtrim($urlToSitemapDirectory, '/');
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
		$fileUrls = [];
		$partialExtractor = new PartialDataExtractor($extractor, $this->limitOfSitemapRecords);

		while(!$partialExtractor->isEndOfParts()) {
			$nameOfSitemapFile = $this->generateSitemapFile($fileName, $extractor);
			$fileNames[] = $this->urlToSitemapDirectory.$nameOfSitemapFile;
		}

		return $this->renderAndWriteSitemapIndex($fileName, $fileUrls);
	}

	/**
	 * Return file extension
	 *
	 * @param string $fileName
	 *
	 * @return string
	 */
	protected function getFileExtension($fileName)
	{
		return mb_substr($fileName, mb_strrpos($fileName, '.'));
	}

	/**
	 * Render and write sitemap index file
	 *
	 * @param string $fileName
	 * @param array $fileUrls
	 *
	 * @return string
	 */
	protected function renderAndWriteSitemapIndex($fileName, array $fileUrls)
	{
		$sitemapIndex = $this->indexRenderer->render($fileUrls);

		return $this->writer->write($fileName, $sitemapIndex);
	}

	/**
	 * Generate sitemap file and return his name
	 *
	 * @param string $fileName
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	protected function generateSitemapFile($fileName, DataExtractorInterface $extractor)
	{
		static $fileIndex = 1;

		$nameOfSitemapFile = preg_replace('/(.*)(\.[\w\d]+)$/', sprintf('$1.%d.$2', $fileIndex), $fileName);
		$this->generator->generate($nameOfSitemapFile, $extractor);

		return $nameOfSitemapFile;
	}
}