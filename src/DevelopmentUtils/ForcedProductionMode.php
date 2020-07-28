<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\Neon\Neon;
use Nette\StaticClass;
use Nette\Utils\FileSystem;
use Wavevision\Utils\Arrays;

class ForcedProductionMode
{

	use StaticClass;

	/**
	 * @param string[] $parameterPath
	 */
	public static function detect(
		string $configPath,
		array $parameterPath = ['parameters', 'forceProductionMode']
	): bool {
		$config = Neon::decode(FileSystem::read($configPath));
		return Arrays::getNestedValue($config, ...$parameterPath) === true;
	}

}
