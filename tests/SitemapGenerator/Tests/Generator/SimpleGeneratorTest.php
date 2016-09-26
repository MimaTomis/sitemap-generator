<?php
namespace SitemapGenerator\Tests\Generator;

use SitemapGenerator\Entity\SitemapItem;
use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Generator\SimpleGenerator;
use SitemapGenerator\Renderer\SitemapRenderer;
use SitemapGenerator\Writer\SimpleWriter;

class SimpleGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleGenerator
     */
    protected $simpleGenerator;
    /**
     * @var SitemapRenderer
     */
    protected $sitemapRenderer;

    public function setUp()
    {
        $this->sitemapRenderer = new SitemapRenderer();
        $this->simpleGenerator = new SimpleGenerator(
            new SimpleWriter(TEMP_DIR),
            $this->sitemapRenderer
        );
    }

    public function tearDown()
    {
        @file_put_contents(TEMP_DIR.'/empty.xml', '');
        @unlink(TEMP_DIR.'/new.xml');
    }

    /**
     * @dataProvider generatorDataProvider
     *
     * @param $fileName
     * @param $items
     */
    public function testGenerate($fileName, $items)
    {
        $extractor = $this->getMock(DataExtractorInterface::class);
        $extractor->expects($this->atLeastOnce())
            ->method('extractData')
            ->willReturn(new \ArrayIterator($items));

        $filePath = $this->simpleGenerator->generate($fileName, $extractor);

        $this->assertXmlStringEqualsXmlFile($filePath, $this->sitemapRenderer->render($extractor));
    }

    public function generatorDataProvider()
    {
        return [
            [
                'empty.xml',
                [
                    new SitemapItem('http://test.com'),
                    new SitemapItem('http://test2.com')
                ]
            ],
            [
                'new.xml',
                [
                    new SitemapItem('http://test4.com'),
                    new SitemapItem('http://test3.com')
                ]
            ]
        ];
    }
}