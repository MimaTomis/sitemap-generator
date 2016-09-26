<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Renderer\SitemapIndexRenderer;
use SitemapGenerator\Renderer\SitemapIndexRendererInterface;
use SitemapGenerator\Renderer\SitemapRenderer;
use SitemapGenerator\Renderer\SitemapRendererInterface;
use SitemapGenerator\Writer\SimpleWriter;
use SitemapGenerator\Writer\WriterInterface;

abstract class AbstractGeneratorFactory implements GeneratorFactoryInterface
{
    /**
     * @var WriterInterface
     */
    private $writer;

    public function __construct(WriterInterface $writer = null)
    {
        $this->writer = $writer;
    }

    /**
     * Create sitemap writer
     *
     * @param string $dirPath
     *
     * @return WriterInterface
     */
    protected function createWriter($dirPath)
    {
        $writer = $this->writer ?: new SimpleWriter($dirPath);
        $writer->setDirectoryToSaveSitemap($dirPath);

        return $writer;
    }

    /**
     * Create sitemap renderer
     *
     * @return SitemapRendererInterface
     */
    protected function createSitemapRenderer()
    {
        return new SitemapRenderer();
    }

    /**
     * Create sitemap index renderer
     *
     * @return SitemapIndexRendererInterface
     */
    protected function createSitemapIndexRenderer()
    {
        return new SitemapIndexRenderer();
    }
}