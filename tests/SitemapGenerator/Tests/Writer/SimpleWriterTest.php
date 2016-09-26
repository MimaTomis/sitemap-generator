<?php
namespace SitemapGenerator\Tests\Writer;

use SitemapGenerator\Exception\NotWritableException;
use SitemapGenerator\Writer\SimpleWriter;

class SimpleWriterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SimpleWriter
     */
    protected $simpleWriter;

    public function setUp()
    {
        $this->simpleWriter = new SimpleWriter(TEMP_DIR);
    }

    public function tearDown()
    {
        @unlink(TEMP_DIR.'/file1.xml');
        chmod(TEMP_DIR.'/empty.xml', 0765);
        file_put_contents(TEMP_DIR.'/empty.xml', '');
    }

    public function testWriteNotExistsFile()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?><tag>abc</tag>';

        $this->simpleWriter->write('/file1.xml', $content);

        $this->assertFileExists(TEMP_DIR.'/file1.xml');
        $this->assertXmlStringEqualsXmlFile(TEMP_DIR.'/file1.xml', $content);
    }

    public function testWriteExistsFile()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?><tag>abc</tag>';

        $this->simpleWriter->write('/empty.xml', $content);

        $this->assertFileExists(TEMP_DIR.'/empty.xml');
        $this->assertXmlStringEqualsXmlFile(TEMP_DIR.'/empty.xml', $content);
    }

    public function testWriteExistsNonWritableFile()
    {
        $this->setExpectedException(NotWritableException::class);
        $content = '<?xml version="1.0" encoding="UTF-8"?><tag>abc</tag>';

        chmod(TEMP_DIR.'/empty.xml', 0555);
        $this->simpleWriter->write('/empty.xml', $content);
    }
}