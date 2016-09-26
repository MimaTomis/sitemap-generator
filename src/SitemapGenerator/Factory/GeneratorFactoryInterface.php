<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\GeneratorInterface;

interface GeneratorFactoryInterface
{
    /**
     * @param string $directoryToSaveSitemap
     *
     * @return GeneratorInterface
     */
    public function createGenerator($directoryToSaveSitemap);
}