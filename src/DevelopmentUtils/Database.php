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

	/**
	 * @param array<mixed> $config
	 */
	public static function mysqlConfig(array $config): string
	{
		$parts = [];
		$mapping = [
			'host' => "-h'%s'",
			'user' => "-u'%s'",
			'password' => "-p'%s'",
		];
		foreach ($mapping as $configKey => $template) {
			if (isset($config[$configKey])) {
				$parts[] = sprintf($template, $config[$configKey]);
			}
		}
		return implode(' ', $parts);
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
		$this->drop();
		CliCommand::printInfo("Creating database $databaseName.");
		$this->mysql("-e 'CREATE DATABASE `$databaseName`'");
	}

	public function drop(): void
	{
		$databaseName = $this->config['name'];
		CliCommand::printInfo("Dropping database $databaseName.");
		$this->mysql("-e 'DROP DATABASE IF EXISTS `$databaseName`'");
	}

	private function mysql(string $command): void
	{
		CliCommand::exec(implode(' ', ['mysql', self::mysqlConfig($this->config), $command]));
	}

}
