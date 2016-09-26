<?php
namespace SitemapGenerator\Entity;

class SitemapItem
{
	const FREQUENCY_ALWAYS = 'always';
	const FREQUENCY_HOURLY = 'hourly';
	const FREQUENCY_DAILY = 'daily';
	const FREQUENCY_WEEKLY = 'weekly';
	const FREQUENCY_MONTHLY = 'monthly';
	const FREQUENCY_EARLY = 'early';
	const FREQUENCY_NEVER = 'never';

	/**
	 * @var string
	 */
	protected $location;
	/**
	 * @var \DateTime
	 */
	protected $lastModified;
	/**
	 * @var string
	 */
	protected $changeFrequency;
	/**
	 * @var float
	 */
	protected $priority;

	public function __construct(
		$location,
		\DateTime $lastModified = null,
		$changeFrequency = null,
		$priority = null
	)
	{

		$this->location = $location;
		$this->lastModified = $lastModified;
		$this->changeFrequency = $changeFrequency;
		$this->priority = $priority;
	}

	/**
	 * URL of the page.
	 * Read that document: http://www.sitemaps.org/protocol.html#locdef
	 *
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * The date of last modification of the file.
	 * Read that document: http://www.sitemaps.org/protocol.html#lastmoddef
	 *
	 * @return \DateTime
	 */
	public function getLastModified()
	{
		return $this->lastModified;
	}

	/**
	 * How frequently the page is likely to change.
	 * Read that document: http://www.sitemaps.org/protocol.html#changefreqdef
	 *
	 * @return string
	 */
	public function getChangeFrequency()
	{
		return $this->changeFrequency;
	}

	/**
	 * The priority of this URL relative to other URLs on your site.
	 * Read that document: http://www.sitemaps.org/protocol.html#prioritydef
	 *
	 * @return float
	 */
	public function getPriority()
	{
		return $this->priority;
	}
}