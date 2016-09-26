<?php
namespace SitemapGenerator\Tests\Factory;

use SitemapGenerator\Factory\MultipleGeneratorFactory;
use SitemapGenerator\Generator\MultipleGenerator;
use SitemapGenerator\Writer\WriterInterface;

class MultipleGeneratorFactoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCreateGenerator()
	{
		$factory = new MultipleGeneratorFactory();
		$generator = $factory->createGenerator(TEMP_DIR);

		$this->assertInstanceOf(MultipleGenerator::class, $generator);
	}

	public function testCreateGeneratorWithCustomWriter()
	{
		$writer = $this->getMock(WriterInterface::class);
		$writer->expects($this->once())
			->method('setDirectoryToSaveSitemap')
			->with($this->equalTo(TEMP_DIR));

		$factory = new MultipleGeneratorFactory($writer);
		$generator = $factory->createGenerator(TEMP_DIR);

		$this->assertInstanceOf(MultipleGenerator::class, $generator);
	}
}