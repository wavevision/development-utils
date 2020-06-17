<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use ReflectionClass;
use Wavevision\Utils\Strings;
use Wavevision\Utils\Tokenizer\Tokenizer;
use Wavevision\Utils\Tokenizer\TokenizeResult;

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
			$name = strtoupper($this->camelCaseToDashCase($value));
			echo sprintf("public const %s = '%s';", $name, $value) . "\n";
		}
	}

	private function camelCaseToDashCase(string $s): string
	{
		return strtolower(Strings::replace($s, '/([a-zA-Z])(?=[A-Z])/', '$1_'));
	}
}