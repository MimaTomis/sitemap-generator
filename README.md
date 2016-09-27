# Sitemap generator

Library for generate sitemap.xml. Easy to use and very extensible. It allows you to create custom data sources.

* [Installation](#installation)
* [Usage](#usage)

## Installation

Install with composer from command line:

```
composer require mima/sitemap-generator
```

Or add dependency to require section in your composer.json:

```json
{
    "require": {
        "mima/sitemap-generator": "~1.0"
    }
}
```

## Usage

To start, you must to create data extractor. For this, define subclass of `SitemapRenderer\Extractor\DataExtractorInterface`.

As sample, we create following data extractor:

```php
namespace MyNamespace\SitemapGenerator\Extractor;

use SitemapGenerator\Extractor\DataExtractorInterface;
use SitemapGenerator\Entity\SitemapItem;

class FromArrayDataExtractor implements DataExtractorInterface
{
    /**
     * This method return \Generator, which at each iteration returns instance of SitemapItem
     *
     * @return |Generator
     */
    public function extractData()
    {
        // load data and each them
        foreach ($this->loadData() as $data) {
            // create instance of SitemapItem based on loaded data
            $item = new SitemapItem('/page-'.$data['id'], new \DateTime($data['created_at']));

            // return this instance
            yield $item;
        }
    }

    /**
     * Load data from array, as samle.
     * It can be a database query, or query to external API.
     *
     * @return array
     */
    protected function loadData()
    {
        return [
            [
                'id' => 1,
                'created_at' => '2016-09-12 00:00:00'
            ],
            [
                'id' => 2,
                'created_at' => '2016-09-12 03:40:00'
            ]
        ];
    }
}
```

Now we can generate a sitemap.xml:

```php
use SitemapGenerator\Factory\SimpleGeneratorFactory;
use MyNamespace\SitemapGenerator\Extractor\FromArrayDataExtractor;

/**
 * This is a directory, where the sitemap will be saved.
 * It must exist in the file system and be available for recording.
 */
$directoryToSaveSitemap = './web';

// Create instance of extractor, which we defined earlier
$extractor = new FromArrayDataExtractor();

// Create instance of factory for simple sitemap generator
$simpleGeneratorFactory = new SimpleGeneratorFactory();

// Create generator by factory
$generator = $simpleGeneratorFactory->createGenerator($directoryToSaveSitemap);

/**
 * Generate sitemap by data, which return extractor.
 * This method return path to generated file.
 */
$filePath = $generator->generate($extractor);
```