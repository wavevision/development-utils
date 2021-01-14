<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\StaticClass;
use Wavevision\Utils\ExternalProgram\Executor;
use function implode;
use function sprintf;

class Database
{

	use StaticClass;

	public static function populate(string $configFile, string $pathToDbDump): void
	{
		$databaseConfig = self::databaseConfig($configFile);
		$databaseName = $databaseConfig['name'];
		$mysql = self::mysql($databaseConfig);
		$mysql('mysql', "$databaseName < $pathToDbDump");
	}

	public static function create(string $configFile): void
	{
		$databaseConfig = self::databaseConfig($configFile);
		$databaseName = $databaseConfig['name'];
		$mysql = self::mysql($databaseConfig);
		$mysql('mysql', "-e 'DROP DATABASE IF EXISTS `$databaseName`'");
		$mysql(
			'mysql',
			"-e 'CREATE DATABASE `$databaseName`'"
		);
	}

	/**
	 * @param array<mixed> $config
	 */
	public static function mysql(array $config): callable
	{
		return function (string $base, string $command) use ($config): void {
			self::bash(implode(' ', [$base, self::mysqlConfig($config), $command]));
		};
	}

	/**
	 * @return array<mixed>
	 */
	private static function databaseConfig(string $configFile): array
	{
		return NeonConfig::read($configFile)['parameters']['database'];
	}

	private static function bash(string $command): void
	{
		echo "$command\n";
		Executor::execute($command);
	}

	/**
	 * @param array<mixed> $database
	 */
	private static function mysqlConfig(array $database): string
	{
		return sprintf("-h'%s' -u'%s' -p'%s'", $database['host'], $database['user'], $database['password']);
	}

}
