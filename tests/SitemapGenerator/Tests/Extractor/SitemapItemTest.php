<?php
namespace SitemapGenerator\Tests\Extractor;

use SitemapGenerator\Extractor\SitemapItem;

class SitemapItemTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider itemDataProvider
	 *
	 * @param string $url
	 * @param \DateTime $modified
	 * @param null $changeFreq
	 * @param null $priority
	 */
	public function testCreateItem($url, $modified, $changeFreq = null, $priority = null)
	{
		$item = $this->createItem($url, $modified, $changeFreq, $priority);
		$this->assertInstanceOf(SitemapItem::class, $item);
	}

	/**
	 * @dataProvider itemDataProvider
	 *
	 * @param string $url
	 * @param \DateTime $modified
	 * @param null $changeFreq
	 * @param null $priority
	 */
	public function testItemGetters($url, $modified, $changeFreq = null, $priority = null)
	{
		$item = $this->createItem($url, $modified, $changeFreq, $priority);

		$this->assertEquals($url, $item->getLocation());
		$this->assertEquals($modified, $item->getLastModified());

		if (!is_null($changeFreq)) {
			$this->assertEquals($changeFreq, $item->getChangeFrequency());
		}

		if (!is_null($priority)) {
			$this->assertEquals($priority, $item->getPriority());
		}
	}

	public function itemDataProvider()
	{
		return [
			['http://test.com/abc', new \DateTime(), SitemapItem::FREQUENCY_ALWAYS, 0.7],
			['http://test.com/asef', new \DateTime(), SitemapItem::FREQUENCY_ALWAYS],
			['http://test.com/vbcsd', new \DateTime()]
		];
	}

	/**
	 * @param string $url
	 * @param \DateTime $modified
	 * @param null $changeFreq
	 * @param null $priority
	 *
	 * @return SitemapItem
	 */
	protected function createItem($url, $modified, $changeFreq = null, $priority = null)
	{
		if (!is_null($changeFreq) && !is_null($priority))
			$item = new SitemapItem($url, $modified, $changeFreq, $priority);
		else if (!is_null($changeFreq))
			$item = new SitemapItem($url, $modified, $changeFreq);
		else if (!is_null($priority))
			$item = new SitemapItem($url, $modified, SitemapItem::FREQUENCY_ALWAYS, $priority);
		else
			$item = new SitemapItem($url, $modified);

		return $item;
	}
}