<?php
namespace SitemapGenerator\Tests\Extractor;

use SitemapGenerator\Extractor\CompositeDataExtractor;
use SitemapGenerator\Extractor\DataExtractorInterface;

class CompositeDataExtractorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var CompositeDataExtractor
	 */
	protected $compositeExtractor;

	public function setUp()
	{
		$this->compositeExtractor = new CompositeDataExtractor();
	}

	/**
	 * @dataProvider extractorsDataProvider
	 */
	public function testAttachExtractor()
	{
		$arrays = func_get_args();

		foreach ($arrays as $array) {
			$extractor = $this->getMock(DataExtractorInterface::class);
			$extractor
				->expects($this->once())
				->method('extractData')
				->willReturn(new \ArrayIterator($array));

			$this->compositeExtractor->attachExtractor($extractor);
		}
	}

	public function testAttachInvalidExtractor()
	{
		$this->setExpectedException(\UnexpectedValueException::class);

		$extractor = $this->getMock(DataExtractorInterface::class);
		$extractor
			->expects($this->once())
			->method('extractData')
			->willReturn(null);

		$this->compositeExtractor->attachExtractor($extractor);

		$extractor = $this->getMock(DataExtractorInterface::class);
		$extractor
			->expects($this->once())
			->method('extractData')
			->willReturn([]);

		$this->compositeExtractor->attachExtractor($extractor);
	}

	/**
	 * @dataProvider extractorsDataProvider
	 */
	public function testExtractData()
	{
		$arrays = func_get_args();

		foreach ($arrays as $array) {
			$extractor = $this->getMock(DataExtractorInterface::class);
			$extractor
				->expects($this->once())
				->method('extractData')
				->willReturn(new \ArrayIterator($array));

			$this->compositeExtractor->attachExtractor($extractor);
		}

		$mergedArray = call_user_func_array('array_merge', $arrays);
		$validatedItems = [];

		foreach ($this->compositeExtractor->extractData() as $index => $item) {
			$this->assertNotContains($item, $validatedItems);
			$this->assertContains($item, $mergedArray);

			$key = array_search($item, $mergedArray);
			$this->assertEquals($key, $index);

			$validatedItems[] = $item;
		}
	}

	public function extractorsDataProvider()
	{
		return [
			[['a', 'b', 'c'], ['e', 'f']],
			[['a', 'd'], ['c', 'f'], ['e']],
			[['a'], ['b', 'c', 'd'], ['e', 'f', 'g', 'h']]
		];
	}
}