<?php
namespace SitemapGenerator\Factory;

use SitemapGenerator\Generator\MultipleGenerator;
use SitemapGenerator\Generator\SimpleGenerator;

class MultipleGeneratorFactory extends AbstractGeneratorFactory
{
	/**
	 * @param string $directoryToSaveSitemap
	 *
	 * @return MultipleGenerator
	 */
	public function createGenerator($directoryToSaveSitemap)
	{
		$writer = $this->createWriter($directoryToSaveSitemap);

		return new MultipleGenerator(
			$writer,
			new SimpleGenerator($writer, $this->createSitemapRenderer()),
			$this->createSitemapIndexRenderer()
		);
	}
}