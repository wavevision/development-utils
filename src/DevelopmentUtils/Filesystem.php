<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use function sprintf;

class Filesystem
{

	/**
	 * @param array<string, string> $remoteFiles2LocalFiles
	 */
	public static function downloadRemote(
		string $remote,
		array $remoteFiles2LocalFiles,
		string $remoteDatabaseName,
		string $localDatabaseDumpFile
	): void {
		self::rsync('remote', 'local');
	}

	public static function downloadRemoteFile(string $remote, string $local): void
	{
	}

	private static function rsync(string $source, string $destination): void
	{
		Cli::command(sprintf('rsync -chavzP --stats "%s" "%s"', $source, $destination));
	}

}
