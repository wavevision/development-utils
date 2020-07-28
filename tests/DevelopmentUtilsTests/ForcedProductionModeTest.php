<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtilsTests;

use PHPUnit\Framework\TestCase;
use Wavevision\DevelopmentUtils\ForcedProductionMode;

class ForcedProductionModeTest extends TestCase
{

	public function testReadingFile(): void
	{
		$result = ForcedProductionMode::detect(
			$this->getTestFilePath()
		);
		$this->assertEquals(true, $result);
	}

	public function testCustomParameterPath(): void
	{
		$result = ForcedProductionMode::detect(
			$this->getTestFilePath(),
			["parameters2", "nestedSomething", "forceProductionMode"]
		);
		$this->assertEquals(true, $result);
	}

	public function testCustomParameterPath2(): void
	{
		$result = ForcedProductionMode::detect(
			$this->getTestFilePath(),
			["parameters2", "nestedSomethingElse", "forceProductionMode"]
		);
		$this->assertEquals(false, $result);
	}

	private function getTestFilePath(): string
	{
		return __DIR__ . "/test-input-files/forcedProductionModeTest.neon";
	}

}
