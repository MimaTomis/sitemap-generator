<?php
namespace SitemapGenerator\Tests\Renderer;

use SitemapGenerator\Entity\SitemapItem;
use SitemapGenerator\Renderer\SitemapIndexRenderer;

class SitemapIndexRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SitemapIndexRenderer
     */
    protected $indexRenderer;

    public function setUp()
    {
        date_default_timezone_set('Europe/Moscow');
        $this->indexRenderer = new SitemapIndexRenderer();
    }

    /**
     * @dataProvider indexDataProvider
     *
     * @param string $indexFile
     * @param array $fileUrls
     */
    public function testRender($indexFile, array $fileUrls)
    {
        $content = $this->indexRenderer->render($fileUrls);

        $this->assertXmlStringEqualsXmlFile($indexFile, $content);
    }

    public function indexDataProvider()
    {
        return [
            [
                FIXTURES_DIR.'/sitemap.index.1.xml',
                [
                    new SitemapItem('http://test.com/sitemap.1.xml', new \DateTime('2016-09-12 04:16:21', new \DateTimeZone('Europe/Moscow'))),
                    new SitemapItem('http://test.com/sitemap.2.xml', new \DateTime('2016-09-10 06:13:11', new \DateTimeZone('Europe/Moscow')))
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.index.2.xml',
                [
                    new SitemapItem('http://test.com/sitemap.1.xml', new \DateTime('2016-09-05 01:12:00', new \DateTimeZone('Europe/Zurich')))
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.index.3.xml',
                [
                    new SitemapItem('http://test.com/sitemap.3.xml'),
                    new SitemapItem('http://test.com/sitemap.1.xml', new \DateTime('2016-08-02 03:00:45', new \DateTimeZone('America/Creston'))),
                    new SitemapItem('http://test.com/sitemap.2.xml', new \DateTime('2016-09-03 00:00:00', new \DateTimeZone('Europe/Moscow')))
                ]
            ]
        ];
    }
}