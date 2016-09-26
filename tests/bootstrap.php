<?php
$loader = include __DIR__ . '/../vendor/autoload.php';

if (!$loader)
	die('Load composer and install dependencies before test running');

define('FIXTURES_DIR', realpath(__DIR__.'/fixtures'));
define('TEMP_DIR', realpath(__DIR__.'/temp'));

$loader->add('SitemapGenerator\Tests', __DIR__);