<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Renderer\SitemapIndexRenderer;
use SitemapGenerator\Renderer\SitemapIndexRendererInterface;
use SitemapGenerator\Renderer\SitemapRenderer;
use SitemapGenerator\Renderer\SitemapRendererInterface;
use SitemapGenerator\Writer\SimpleWriter;
use SitemapGenerator\Writer\WriterInterface;

abstract class AbstractFactory implements FactoryInterface
{
    /**
     * Create sitemap writer
     *
     * @param string $dirPath
     *
     * @return WriterInterface
     */
    protected function createWriter($dirPath)
    {
        return new SimpleWriter($dirPath);
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