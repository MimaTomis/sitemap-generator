<?php
namespace SitemapGenerator\Generator;

use SitemapGenerator\Entity\SitemapItem;
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
	/**
	 * @var \DateTime
	 */
	protected $lastModified;

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
	 * Set date of last modified sitemap files
	 *
	 * @param \DateTime $lastModified
	 */
	public function setLastModifiedDate(\DateTime $lastModified)
	{
		$this->lastModified = $lastModified;
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
		$items = [];
		$fileIndex = 1;

		$date = $this->lastModified ?: new \DateTime();
		$partialExtractor = new PartialDataExtractor($extractor, $this->limitOfSitemapRecords);

		while(!$partialExtractor->isEndOfParts()) {
			$nameOfSitemapFile = $this->generateSitemapFile($fileIndex ++, $fileName, $partialExtractor);
			$nameOfSitemapFile = $this->generateUrlToSitemapFile($nameOfSitemapFile);

			$items[] = new SitemapItem($nameOfSitemapFile, $date);
		}

		return $this->renderAndWriteSitemapIndex($fileName, $items);
	}

	/**
	 * Render and write sitemap index file
	 *
	 * @param string $fileName
	 * @param SitemapItem[] $items
	 *
	 * @return string
	 */
	protected function renderAndWriteSitemapIndex($fileName, array $items)
	{
		$sitemapIndex = $this->indexRenderer->render($items);

		return $this->writer->write($fileName, $sitemapIndex);
	}

	/**
	 * Generate sitemap file and return his name
	 *
	 * @param int $fileIndex
	 * @param string $fileName
	 * @param DataExtractorInterface $extractor
	 *
	 * @return string
	 */
	protected function generateSitemapFile($fileIndex, $fileName, DataExtractorInterface $extractor)
	{
		$nameOfSitemapFile = preg_replace('/(.*)(\.[\w\d]+)$/', sprintf('$1.%d$2', $fileIndex), $fileName);
		$this->generator->generate($nameOfSitemapFile, $extractor);

		return $nameOfSitemapFile;
	}

	/**
	 * Generate url to sitemap file
	 *
	 * @param string $nameOfSitemapFile
	 *
	 * @return string
	 */
	protected function generateUrlToSitemapFile($nameOfSitemapFile)
	{
		return rtrim($this->urlToSitemapDirectory,'/').'/'.ltrim($nameOfSitemapFile, '/');
	}
}