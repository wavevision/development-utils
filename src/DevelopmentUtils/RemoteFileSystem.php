<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\SmartObject;
use function sprintf;

class RemoteFileSystem
{

	use SmartObject;

	private string $remote;

	public function __construct(string $remote)
	{
		$this->remote = $remote;
	}

	public function remote2Local(string $remoteFile, string $localFile): void
	{
		$this->rsync("$this->remote:$remoteFile", "$localFile");
	}

	public function cli(string $command): void
	{
		Cli::command(sprintf('ssh %s "%s"', $this->remote, $command));
	}

	private function rsync(string $source, string $destination): void
	{
		Cli::command(sprintf('rsync -chavzP --stats "%s" "%s"', $source, $destination));
	}

}
