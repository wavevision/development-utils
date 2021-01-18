<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

class SetupDevelopment
{

	private DownloadDevelopment $downloadDevelopment;

	private Database $database;

	public function __construct(DownloadDevelopment $downloadDevelopment, Database $database)
	{
		$this->downloadDevelopment = $downloadDevelopment;
		$this->database = $database;
	}

	public function process(): void
	{
		$this->downloadDevelopment->process();
		$this->database->create();
		$this->database->populate($this->downloadDevelopment->getLocalDatabaseDump());
		Cli::printInfo("SUCCESS");
	}

}
