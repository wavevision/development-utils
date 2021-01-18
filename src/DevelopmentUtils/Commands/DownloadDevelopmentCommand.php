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

	private const CONFIG_FILE = 'configFile';

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
		$cli->arg(self::CONFIG_FILE, 'Path to config file', true);
	}

	public function createInstance(Args $args): DownloadDevelopment
	{
		return new DownloadDevelopment(NeonConfig::read($args->getArg(self::CONFIG_FILE)));
	}

}
