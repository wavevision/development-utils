<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Wavevision\Utils\ExternalProgram\Executor;
use Wavevision\Utils\ExternalProgram\Result;

class Cli
{

	public static function command(string $command): Result
	{
		echo "$command\n";
		return Executor::execute($command);
	}

}
