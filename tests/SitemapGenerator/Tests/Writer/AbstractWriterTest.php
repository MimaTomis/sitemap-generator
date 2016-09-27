<?php
namespace SitemapGenerator\Tests\Writer;

use SitemapGenerator\Exception\FileWriteException;
use SitemapGenerator\Exception\NotWritableException;
use SitemapGenerator\Writer\AbstractWriter;

class AbstractWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractWriter
     */
    protected $writer;

    public function setUp()
    {
        $this->writer = $this->getMockBuilder(AbstractWriter::class)
            ->disableOriginalConstructor()
            ->enableProxyingToOriginalMethods()
            ->getMockForAbstractClass();
    }

    public function tearDown()
    {
        chmod(TEMP_DIR, 0755);
        chmod(TEMP_DIR.'/empty.xml', 0765);
    }

    public function testSetDirPathNotWritableDirectory()
    {
        $this->setExpectedException(NotWritableException::class);

        chmod(TEMP_DIR, 0555);
        $this->writer->setDirectoryToSaveSitemap(TEMP_DIR);
    }

    public function testSetDirPathExistsAndWritable()
    {
        $this->writer->setDirectoryToSaveSitemap(TEMP_DIR);
    }

    public function testWriteNotExistsFile()
    {
        // because is abstract class, and him not have implementation for writeContent method
        $this->setExpectedException(FileWriteException::class);

        $this->writer->setDirectoryToSaveSitemap(TEMP_DIR);
        $this->writer->write('file1.xml', 'content');
    }

    public function testWriteExistsNotWritableFile()
    {
        $this->setExpectedException(NotWritableException::class);

        chmod(TEMP_DIR.'/empty.xml', 0555);
        $this->writer->setDirectoryToSaveSitemap(TEMP_DIR);
        $this->writer->write('empty.xml', 'content');
    }

    public function testWriteExistsWritableFile()
    {
        // because is abstract class, and him not have implementation for writeContent method
        $this->setExpectedException(FileWriteException::class);

        $this->writer->setDirectoryToSaveSitemap(TEMP_DIR);
        $this->writer->write('empty.xml', 'content');
    }
}