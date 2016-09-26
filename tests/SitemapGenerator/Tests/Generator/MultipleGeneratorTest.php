<?php
namespace SitemapGenerator\Generator;

use SitemapGenerator\Entity\SitemapItem;
use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Renderer\SitemapIndexRenderer;
use SitemapGenerator\Renderer\SitemapRenderer;
use SitemapGenerator\Writer\SimpleWriter;

class MultipleGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MultipleGenerator
     */
    protected $multipleGenerator;

    public function setUp()
    {
        $writer = new SimpleWriter(TEMP_DIR);

        $this->multipleGenerator = new MultipleGenerator(
            $writer,
            new SimpleGenerator($writer, new SitemapRenderer()),
            new SitemapIndexRenderer()
        );
    }

    public function tearDown()
    {
        @file_put_contents(TEMP_DIR.'/empty.xml', '');

        $iterator = new \DirectoryIterator(TEMP_DIR);

        foreach ($iterator as $file) {
            if ($file->isFile() && !$file->isDot()) {
                if ($file->getBasename() != 'empty.xml') {
                    unlink($file->getPathname());
                }
            }
        }
    }

    /**
     * @dataProvider generatorDataProvider
     *
     * @param $url
     * @param $fileName
     * @param $items
     * @param $limit
     * @param $lastModified
     */
    public function testGenerate($url, $fileName, $items, $limit, $lastModified)
    {
        $extractor = $this->getMock(DataExtractorInterface::class);
        $extractor->expects($this->atLeastOnce())
            ->method('extractData')
            ->willReturn(new \ArrayIterator($items));

        $this->multipleGenerator->setUrlToSitemapDirectory($url);
        $this->multipleGenerator->setLimitOfSitemapRecords($limit);
        $this->multipleGenerator->setLastModifiedDate($lastModified);

        $indexFile = $this->multipleGenerator->generate($fileName, $extractor);

        $this->assertXmlFileEqualsXmlFile(FIXTURES_DIR.'/multiple/'.$fileName, $indexFile);

        $size = ceil(count($items)/$limit);

        for ($i = 1; $i <= $size; $i ++) {
            $sitemapFileName = str_replace('.xml', '.'.$i.'.xml', $fileName);
            $this->assertXmlFileEqualsXmlFile(FIXTURES_DIR.'/multiple/'.$sitemapFileName, TEMP_DIR.'/'.$sitemapFileName);
        }
    }

    public function generatorDataProvider()
    {
        return [
            [
                'http://test.com/abc',
                'empty.xml',
                [
                    new SitemapItem('http://test.com'),
                    new SitemapItem('http://test2.com')
                ],
                1,
                new \DateTime('2016-09-12')
            ],
            [
                'http://test.com/cde/',
                'new.xml',
                [
                    new SitemapItem('http://test4.com'),
                    new SitemapItem('http://test3.com'),
                    new SitemapItem('http://test2.com'),
                    new SitemapItem('http://test6.com')
                ],
                2,
                new \DateTime('2016-09-13')
            ],
            [
                'http://test.com',
                'sitemap.xml',
                [
                    new SitemapItem('http://test1.com'),
                    new SitemapItem('http://test2.com'),
                    new SitemapItem('http://test3.com'),
                    new SitemapItem('http://test4.com'),
                    new SitemapItem('http://test5.com'),
                    new SitemapItem('http://test6.com'),
                    new SitemapItem('http://test7.com'),
                    new SitemapItem('http://test8.com')
                ],
                3,
                new \DateTime('2016-09-14')
            ],
        ];
    }
}