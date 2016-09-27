<?php
namespace SitemapGenerator\Extractor;

use SitemapGenerator\Entity\SitemapItem;

class PartialDataExtractor implements DataExtractorInterface
{
	/**
	 * @var DataExtractorInterface
	 */
	protected $dataExtractor;
	/**
	 * @var int
	 */
	protected $sizeOfPart;
	/**
	 * @var \Generator
	 */
	protected $iterator;
	/**
	 * @var boolean
	 */
	protected $isEndOfParts = false;

	public function __construct(DataExtractorInterface $dataExtractor, $sizeOfPart = 10000)
	{
		$this->dataExtractor = $dataExtractor;
		$this->sizeOfPart = $sizeOfPart;
	}

	/**
	 * This method return \Generator, which at each iteration returns instance of SitemapItem
	 *
	 * @return \Generator
	 */
	public function extractData()
	{
		$i = 0;
		$iterator = $this->getIterator();

		while($iterator->valid()) {
			if ($this->isEndOfCurrentPart($i ++)) {
				break;
			}

			yield $iterator->current();

			$iterator->next();
		}

		$this->isEndOfParts = !$i;
	}

	/**
	 * Return true if all parts iterated
	 *
	 * @return bool
	 */
	public function isEndOfParts()
	{
		return !$this->getIterator()->valid();
	}

	/**
	 * Return true if item is last of part
	 *
	 * @param $itemIndexInPart
	 *
	 * @return boolean
	 */
	protected function isEndOfCurrentPart($itemIndexInPart)
	{
		return ($this->sizeOfPart ==  $itemIndexInPart);
	}

	/**
	 * Get iterator by base data extractor
	 *
	 * @return \Generator
	 */
	protected function getIterator()
	{
		if (!$this->iterator) {
			$this->iterator = $this->dataExtractor->extractData();
		}

		return $this->iterator;
	}
}