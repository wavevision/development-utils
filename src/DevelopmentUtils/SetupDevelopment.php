<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\SmartObject;

class SetupDevelopment
{

	use SmartObject;

	public function process(string $downloadDevelopmentConfig, string $localConfig): void
	{
		$downloadDevelopment = DownloadDevelopment::fromNeon($downloadDevelopmentConfig);
		$downloadDevelopment->process();
		Database::create($localConfig);
		Database::populate($localConfig, $downloadDevelopment->getLocalDatabaseDump());
		Cli::printInfo("SUCCESS");
	}

}
