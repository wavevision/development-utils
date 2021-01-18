<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use function sprintf;

class FileSystem
{

	public static function remote2Local(string $remote): callable
	{
		return function (string $remoteFile, string $localFile) use ($remote): void {
			self::rsync("$remote:$remoteFile", $localFile);
		};
	}

	public static function remoteCli(string $remote): callable
	{
		return function ($command) use ($remote): void {
			Cli::command(sprintf('ssh %s "%s"', $remote, $command));
		};
	}

	private static function rsync(string $source, string $destination): void
	{
		Cli::command(sprintf('rsync -chavzP --stats "%s" "%s"', $source, $destination));
	}

}
