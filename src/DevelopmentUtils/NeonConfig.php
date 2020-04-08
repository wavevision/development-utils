<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\Neon\Neon;
use Nette\StaticClass;
use Nette\Utils\FileSystem;

class NeonConfig
{

	use StaticClass;

	/**
	 * @return array<mixed>
	 */
	public static function read(string $config): array
	{
		return Neon::decode(FileSystem::read($config));
	}

}
