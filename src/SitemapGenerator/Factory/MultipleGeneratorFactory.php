<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\MultipleGenerator;
use SitemapGenerator\Generator\SimpleGenerator;
use SitemapGenerator\Writer\WriterInterface;

class MultipleGeneratorFactory extends AbstractGeneratorFactory
{
	/**
	 * @var string
	 */
	protected $urlToSitemapDirectory;
	/**
	 * @var int
	 */
	protected $limitOfSitemapRecords;
	/**
	 * @var \DateTime
	 */
	protected $lastModified;

	/**
	 * @param string $directoryToSaveSitemap
	 *
	 * @return MultipleGenerator
	 */
	public function createGenerator($directoryToSaveSitemap)
	{
		$writer = $this->createWriter($directoryToSaveSitemap);
		$simpleGenerator = $this->createSimpleGenerator($writer);
		$indexRenderer = $this->createSitemapIndexRenderer();

		$generator = new MultipleGenerator($writer, $simpleGenerator, $indexRenderer);

		if ($this->urlToSitemapDirectory) {
			$generator->setUrlToSitemapDirectory($this->urlToSitemapDirectory);
		}

		if ($this->limitOfSitemapRecords) {
			$generator->setLimitOfSitemapRecords($this->limitOfSitemapRecords);
		}

		if ($this->lastModified) {
			$generator->setLastModifiedDate($this->lastModified);
		}

		return $generator;
	}

	/**
	 * Set url to sitemap directory
	 *
	 * @param string $urlToSitemapDirectory
	 */
	public function setUrlToSitemapDirectory($urlToSitemapDirectory)
	{
		$this->urlToSitemapDirectory = $urlToSitemapDirectory;
	}

	/**
	 * Set limit of records in sitemap file
	 *
	 * @param int $limitOfSitemapRecords
	 */
	public function setLimitOfSitemapRecords($limitOfSitemapRecords)
	{
		$this->limitOfSitemapRecords = $limitOfSitemapRecords;
	}

	/**
	 * Set date of last modification sitemap file
	 *
	 * @param \DateTime $lastModified
	 */
	public function setLastModified(\DateTime $lastModified)
	{
		$this->lastModified = $lastModified;
	}

	/**
	 * Create instance of simple sitemap generator
	 *
	 * @param WriterInterface $writer
	 *
	 * @return SimpleGenerator
	 */
	protected function createSimpleGenerator(WriterInterface $writer)
	{
		return new SimpleGenerator($writer, $this->createSitemapRenderer());
	}
}