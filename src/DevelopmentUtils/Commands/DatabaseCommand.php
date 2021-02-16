<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils\Commands;

use Garden\Cli\Args;
use Garden\Cli\Cli;
use Wavevision\DevelopmentUtils\Database;
use Wavevision\DevelopmentUtils\NeonConfig;

class DatabaseCommand
{

	private const CONFIG_LOCAL = 'configLocal';

	private const DATABASE_DUMP_FILE = 'databaseDumpFile';

	/**
	 * @param array<mixed> $argv
	 */
	public function runCreate(array $argv): void
	{
		$cli = new Cli();
		$cli->description('Drop and create database.');
		$this->defineArg($cli);
		$this->createInstance($cli->parse($argv))->create();
	}

	/**
	 * @param array<mixed> $argv
	 */
	public function runDrop(array $argv): void
	{
		$cli = new Cli();
		$cli->description('Dropdatabase.');
		$this->defineArg($cli);
		$this->createInstance($cli->parse($argv))->drop();
	}

	/**
	 * @param array<mixed> $argv
	 */
	public function runPopulate(array $argv): void
	{
		$cli = new Cli();
		$cli->description('Populate database.');
		$this->defineArg($cli);
		$cli->arg(self::DATABASE_DUMP_FILE, 'Path to database dump file', true);
		$this->createInstance($cli->parse($argv))->populate(self::DATABASE_DUMP_FILE);
	}

	public function defineArg(Cli $cli): void
	{
		$cli->arg(self::CONFIG_LOCAL, 'Path to config, where database credentials are defined.', true);
	}

	public function createInstance(Args $args): Database
	{
		return new Database(NeonConfig::read($args->getArg(self::CONFIG_LOCAL))['parameters']['database']);
	}

}
