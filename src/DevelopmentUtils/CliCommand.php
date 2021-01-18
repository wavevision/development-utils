<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Codedungeon\PHPCliColors\Color;
use function passthru;
use const PHP_EOL;

class CliCommand
{

	public static function exec(string $command): void
	{
		self::printCommand($command);
		passthru($command);
	}

	public static function println(string $line, ?string $color = null): void
	{
		if ($color) {
			echo $color, $line, Color::RESET, PHP_EOL;
		} else {
			echo $line, PHP_EOL;
		}
	}

	public static function printInfo(string $text): void
	{
		self::println($text, Color::GREEN);
	}

	private static function printCommand(string $text): void
	{
		self::println($text, Color::BLUE);
	}

}
