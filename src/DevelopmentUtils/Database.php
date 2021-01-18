<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\SmartObject;
use function implode;
use function sprintf;

class Database
{

	use SmartObject;

	/**
	 * @var array<mixed>
	 */
	private array $config;

	/**
	 * @param array<mixed> $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function populate(string $pathToDbDump): void
	{
		$databaseName = $this->config['name'];
		CliCommand::printInfo("Populating database $databaseName using $pathToDbDump.");
		$this->mysql("$databaseName < $pathToDbDump");
	}

	public function create(): void
	{
		$databaseName = $this->config['name'];
		CliCommand::printInfo("Dropping database $databaseName.");
		$this->mysql("-e 'DROP DATABASE IF EXISTS `$databaseName`'");
		CliCommand::printInfo("Creating database $databaseName.");
		$this->mysql("-e 'CREATE DATABASE `$databaseName`'");
	}

	private function mysql(string $command): void
	{
		CliCommand::exec(implode(' ', ['mysql', self::mysqlConfig(), $command]));
	}

	private function mysqlConfig(): string
	{
		return sprintf("-h'%s' -u'%s' -p'%s'", $this->config['host'], $this->config['user'], $this->config['password']);
	}

}
