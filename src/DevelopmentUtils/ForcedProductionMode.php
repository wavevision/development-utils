<?php declare(strict_types = 1);

namespace Wavevision\DevelopmentUtils;

use Nette\Neon\Neon;
use Nette\StaticClass;

class ForcedProductionMode{
    use StaticClass;

    public static function detect(string $configPath):bool {
        $localConfig = Neon::decode(file_get_contents($configPath));
        if($localConfig['parameters']['forceProductionMode'])
            return true;
        return false;
    }
}