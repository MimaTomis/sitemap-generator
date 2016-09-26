<?php
namespace SitemapGenerator\Tests\Factory;

use SitemapGenerator\Factory\SimpleGeneratorFactory;
use SitemapGenerator\Generator\GeneratorInterface;
use SitemapGenerator\Writer\WriterInterface;

class SimpleGeneratorFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCreateGenerator()
	{
		$factory = new SimpleGeneratorFactory();
		$generator = $factory->createGenerator(TEMP_DIR);

		$this->assertInstanceOf(GeneratorInterface::class, $generator);
	}

	public function testCreateGeneratorWithCustomWriter()
	{
		$writer = $this->getMock(WriterInterface::class);
		$writer->expects($this->once())
			->method('setDirectoryToSaveSitemap')
			->with($this->equalTo(TEMP_DIR));

		$factory = new SimpleGeneratorFactory($writer);
		$generator = $factory->createGenerator(TEMP_DIR);

		$this->assertInstanceOf(GeneratorInterface::class, $generator);
	}
}