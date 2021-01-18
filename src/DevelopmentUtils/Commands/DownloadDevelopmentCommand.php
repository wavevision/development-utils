<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils\Commands;

use Garden\Cli\Args;
use Garden\Cli\Cli;
use Nette\SmartObject;
use Wavevision\DevelopmentUtils\DownloadDevelopment;
use Wavevision\DevelopmentUtils\NeonConfig;

class DownloadDevelopmentCommand
{

	use SmartObject;

	private const DOWNLOAD_DEVELOPMENT_CONFIG = 'downloadDevelopmentConfigFile';

	/**
	 * @param array<mixed> $argv
	 */
	public function run(array $argv): void
	{
		$cli = new Cli();
		$cli->description('Download remote environment to local.');
		$this->defineArg($cli);
		$this->createInstance($cli->parse($argv))->process();
	}

	public function defineArg(Cli $cli): void
	{
		$cli->arg(
			self::DOWNLOAD_DEVELOPMENT_CONFIG,
			'Path to downloadDevelopment.neon',
			true
		);
	}

	public function createInstance(Args $args): DownloadDevelopment
	{
		return new DownloadDevelopment(NeonConfig::read($args->getArg(self::DOWNLOAD_DEVELOPMENT_CONFIG)));
	}

}
