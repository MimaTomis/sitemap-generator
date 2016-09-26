<?php
namespace SitemapGenerator\Tests\Renderer;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Extractor\SitemapItem;
use SitemapGenerator\Renderer\SitemapRenderer;

class SitemapRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SitemapRenderer
     */
    protected $renderer;

    public function setUp()
    {
        $this->renderer = new SitemapRenderer();
    }

    /**
     * @dataProvider extractorsDataProvider
     *
     * @param string $file
     * @param SitemapItem[] $items
     */
	public function testRender($file, array $items)
    {
        $extractor = $this->getMock(DataExtractorInterface::class);
        $extractor->expects($this->once())
            ->method('extractData')
            ->willReturn(new \ArrayIterator($items));

        $content = $this->renderer->render($extractor);
        $this->assertXmlStringEqualsXmlFile($file, $content);
    }

    public function extractorsDataProvider()
    {
        return [
            [
                FIXTURES_DIR.'/sitemap.1.xml',
                [
                    new SitemapItem('http://test.com/abc', new \DateTime('2016-09-01')),
                    new SitemapItem('http://test.com/efg', new \DateTime('2016-09-02'), SitemapItem::FREQUENCY_NEVER, 0.1)
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.2.xml',
                [
                    new SitemapItem('http://test.com/gt', new \DateTime('2016-09-03'), SitemapItem::FREQUENCY_EARLY),
                    new SitemapItem('http://test.com/vfv', new \DateTime('2016-09-04'), SitemapItem::FREQUENCY_HOURLY, 0.5),
                    new SitemapItem('http://test.com/ghj', new \DateTime('2016-09-05'))
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.3.xml',
                [
                    new SitemapItem('http://test.com/gtfuyt', new \DateTime('2016-09-08'))
                ]
            ]
        ];
    }
}