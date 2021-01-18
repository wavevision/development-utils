<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\Neon\Neon;
use Nette\Utils;
use function sprintf;

class DownloadDevelopment
{

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

	public static function fromNeon(string $configFile): self
	{
		return new self(Neon::decode(Utils\FileSystem::read($configFile)));
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
		$remoteCli = FileSystem::remoteCli($this->remote());
		$database = $this->config['database'];
		$databaseName = $database['name'];
		$remoteDatabaseDump = $database['dump']['remote'];
		Cli::printInfo("Dumping database on remote to file $remoteDatabaseDump.");
		$remoteCli(
			sprintf(
				"mysqldump -h%s -u%s -p%s %s > %s",
				$database['host'],
				$database['user'],
				$database['password'],
				$databaseName,
				$remoteDatabaseDump,
			)
		);
		$remote2Local = $this->remote2Local();
		$remote2Local($remoteDatabaseDump, $this->getLocalDatabaseDump());
	}

	private function filesystem(): void
	{
		$files = $this->config['files'];
		$remoteBase = $files['remote'];
		$localBase = $files['local'];
		$remote2Local = $this->remote2Local();
		foreach ($files['local2Remote'] as $remote => $local) {
			Cli::printInfo("Downloading $remote -> $local");
			$remote2Local("$remoteBase/$remote", "$localBase/$local");
		}
	}

	private function remote2Local(): callable
	{
		return FileSystem::remote2Local($this->remote());
	}

	private function remote(): string
	{
		return sprintf('%s@%s', $this->config['server']['user'], $this->config['server']['host']);
	}

}
