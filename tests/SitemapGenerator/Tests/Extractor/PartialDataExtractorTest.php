<?php
namespace SitemapGenerator\Tests\Extractor;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Extractor\PartialDataExtractor;

class PartialDataExtractorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider extractorsDataProvider
	 *
	 * @param $array
	 * @param $size
	 */
	public function testExtractData($array, $size)
	{
		$extractor = $this->getMock(DataExtractorInterface::class);

		$extractor->expects($this->once())
			->method('extractData')
			->willReturn(new \ArrayIterator($array));

		$partialExtractor = new PartialDataExtractor($extractor, $size);
		$iterations = 0;
		$totalCountItems = 0;

		while(!$partialExtractor->isEndOfParts()) {
			$iterations ++;
			$countItems = 0;

			foreach ($partialExtractor->extractData() as $item) {
				$countItems ++;

				$this->assertContains($item, $array, 'Phantom item');
			}

			$totalCountItems += $countItems;
			$this->assertEquals($size, $countItems, 'Count items in iteration not equal to size of part');
		}

		$this->assertEquals(count($array), $totalCountItems, 'Count iterated items not equals to real');
		$this->assertEquals(ceil(count($array)/$size), $iterations, 'Count expected iteration not equal to real');
	}

	public function extractorsDataProvider()
	{
		return [
			[['a', 'b', 'c', 'e', 'f', 'h'], 3],
			[['a', 'd', 'c'], 1],
			[['a', 'b'], 2],
			[['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'], 2]
		];
	}
}