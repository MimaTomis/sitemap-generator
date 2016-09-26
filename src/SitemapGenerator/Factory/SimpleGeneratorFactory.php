<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\SimpleGenerator;

class SimpleGeneratorFactory extends AbstractGeneratorFactory
{
    /**
     * @param string $directoryToSaveSitemap
     *
     * @return SimpleGenerator
     */
    public function createGenerator($directoryToSaveSitemap)
    {
        return new SimpleGenerator(
            $this->createWriter($directoryToSaveSitemap),
            $this->createSitemapRenderer()
        );
    }
}