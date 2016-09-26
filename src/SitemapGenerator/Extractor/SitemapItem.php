<?php
namespace SitemapGenerator\Extractor;

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
		\DateTime $lastModified,
		$changeFrequency = self::FREQUENCY_MONTHLY,
		$priority = 0.8
	)
	{

		$this->location = $location;
		$this->lastModified = $lastModified;
		$this->changeFrequency = $changeFrequency;
		$this->priority = $priority;
	}

	/**
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastModified()
	{
		return $this->lastModified;
	}

	/**
	 * @return string
	 */
	public function getChangeFrequency()
	{
		return $this->changeFrequency;
	}

	/**
	 * @return float
	 */
	public function getPriority()
	{
		return $this->priority;
	}
}