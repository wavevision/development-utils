<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use ReflectionClass;
use Wavevision\Utils\Strings;
use Wavevision\Utils\Tokenizer\Tokenizer;
use Wavevision\Utils\Tokenizer\TokenizeResult;
use function sprintf;
use function strtoupper;
use const T_CLASS;
use const T_TRAIT;

class GenerateConstants
{

	public function process(string $file): void
	{
		require_once $file;
		$tokenizer = new Tokenizer();
		/** @var TokenizeResult $result */
		$result = $tokenizer->getStructureNameFromFile($file, [T_CLASS, T_TRAIT]);
		/** @var class-string $class */
		$class = $result->getFullyQualifiedName();
		$reflectionClass = new ReflectionClass($class);
		foreach ($reflectionClass->getProperties() as $property) {
			$value = $property->getName();
			$name = strtoupper(Strings::camelCaseToSnakeCase($value));
			echo sprintf("public const %s = '%s';", $name, $value) . "\n";
		}
	}

}
