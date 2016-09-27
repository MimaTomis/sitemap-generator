<?php
namespace SitemapGenerator\Extractor;

interface DataExtractorInterface
{
	/**
	 * This method return \Generator, which at each iteration returns instance of SitemapItem
	 *
	 * @return |Generator
	 */
	public function extractData();
}