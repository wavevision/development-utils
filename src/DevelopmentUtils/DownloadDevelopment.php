<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use function sprintf;

class DownloadDevelopment
{

	/**
	 * @var array<mixed>
	 */
	private array $config;

	private RemoteFileSystem $remoteFileSystem;

	/**
	 * @param array<mixed> $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
		$this->remoteFileSystem = new RemoteFileSystem(
			sprintf('%s@%s', $this->config['server']['user'], $this->config['server']['host'])
		);
	}

	/**
	 * @return array<mixed>
	 */
	public function getConfig(): array
	{
		return $this->config;
	}

	public function getLocalDatabaseDump(): string
	{
		return $this->config['database']['dump']['local'];
	}

	public function process(): void
	{
		$this->database();
		$this->filesystem();
	}

	private function database(): void
	{
		$database = $this->config['database'];
		$databaseName = $database['name'];
		$remoteDatabaseDump = $database['dump']['remote'];
		CliCommand::printInfo("Dumping database on remote to file $remoteDatabaseDump.");
		$this->remoteFileSystem->cli(
			sprintf(
				"mysqldump -h%s -u%s -p%s %s > %s",
				$database['host'],
				$database['user'],
				$database['password'],
				$databaseName,
				$remoteDatabaseDump,
			)
		);
		$this->remoteFileSystem->remote2Local($remoteDatabaseDump, $this->getLocalDatabaseDump());
	}

	private function filesystem(): void
	{
		$files = $this->config['files'];
		$remoteBase = $files['remote'];
		$localBase = $files['local'];
		foreach ($files['local2Remote'] as $remote => $local) {
			$localPath = "$localBase/$local";
			if ($files['clearLocal']) {
				CliCommand::printInfo("Cleaning local $local");
				CliCommand::exec(sprintf('rm -rf "%s"*', $localPath));
			}
			CliCommand::printInfo("Downloading $remote -> $local");
			$this->remoteFileSystem->remote2Local("$remoteBase/$remote", $localPath);
		}
	}

}
