<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\GeneratorInterface;

class SimpleGeneratorFactory implements FactoryInterface
{
    /**
     * @param string $directoryToSaveSitemap
     *
     * @return GeneratorInterface
     */
    public function createGenerator($directoryToSaveSitemap)
    {
        // TODO: Implement createGenerator() method.
    }
}