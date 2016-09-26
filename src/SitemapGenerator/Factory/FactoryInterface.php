<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\GeneratorInterface;

interface FactoryInterface
{
    /**
     * @param string $directoryToSaveSitemap
     *
     * @return GeneratorInterface
     */
    public function createGenerator($directoryToSaveSitemap);
}