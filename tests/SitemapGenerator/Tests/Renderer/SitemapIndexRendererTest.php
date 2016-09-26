<?php
namespace SitemapGenerator\Tests\Renderer;

use SitemapGenerator\Renderer\SitemapIndexRenderer;

class SitemapIndexRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SitemapIndexRenderer
     */
    protected $indexRenderer;

    public function setUp()
    {
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
                    'http://test.com/sitemap.1.xml',
                    'http://test.com/sitemap.2.xml'
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.index.2.xml',
                [
                    'http://test.com/sitemap.1.xml'
                ]
            ],
            [
                FIXTURES_DIR.'/sitemap.index.3.xml',
                [
                    'http://test.com/sitemap.3.xml',
                    'http://test.com/sitemap.1.xml',
                    'http://test.com/sitemap.2.xml'
                ]
            ]
        ];
    }
}