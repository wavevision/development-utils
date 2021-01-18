<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils\Commands;

use Garden\Cli\Cli;
use Nette\SmartObject;
use Wavevision\DevelopmentUtils\SetupDevelopment;

class SetupDevelopmentCommand
{

	use SmartObject;

	/**
	 * @param array<mixed> $argv
	 */
	public function run(array $argv): void
	{
		$databaseCommand = new DatabaseCommand();
		$downloadDevelopmentCommand = new DownloadDevelopmentCommand();
		$cli = new Cli();
		$cli->description('Download and setup development environment');
		$downloadDevelopmentCommand->defineArg($cli);
		$databaseCommand->defineArg($cli);
		$args = $cli->parse($argv, true);
		(new SetupDevelopment(
			$downloadDevelopmentCommand->createInstance($args),
			$databaseCommand->createInstance($args)
		))->process();
	}

}
