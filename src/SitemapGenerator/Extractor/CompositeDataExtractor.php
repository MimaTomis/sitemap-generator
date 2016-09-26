<?php
namespace SitemapGenerator\Extractor;

class CompositeDataExtractor implements DataExtractorInterface
{
    /**
     * @var \AppendIterator|DataExtractorInterface[]
     */
    protected $extractors;

    public function __construct()
    {
        $this->extractors = new \AppendIterator();
    }

    /**
     * Attach data extractor
     *
     * @param DataExtractorInterface $extractor
     */
    public function attachExtractor(DataExtractorInterface $extractor)
    {
        $iterator = $extractor->extractData();

        if (!is_object($iterator) || !$iterator instanceof \Iterator) {
            throw new \UnexpectedValueException('Composite iterator expect instance of \Iterator subclass');
        }

        $this->extractors->append($iterator);
    }

    /**
     * This method return \Generator, which at each iteration returns instance of SitemapItem
     *
     * @return \Generator|SitemapItem[]
     */
    public function extractData()
    {
        foreach ($this->extractors as $item) {
            yield $item;
        }
    }
}