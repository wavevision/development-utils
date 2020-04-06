<?php declare(strict_types=1);


namespace Wavevision\DevelopmentUtils;


use Nette\StaticClass;
use Wavevision\Utils\ExternalProgram\Executor;

class Database
{
    use StaticClass;

    public static function create(string $configFile): void
    {
        $config = NeonConfig::read($configFile);
        $databaseConfig = $config['parameters']['database'];
        $databaseName = $databaseConfig['name'];
        $mysql = self::mysql($databaseConfig);
        $mysql('mysql', "-e 'DROP DATABASE IF EXISTS `$databaseName`'");
        $mysql(
            'mysql',
            "-e 'CREATE DATABASE `$databaseName`'"
        );
    }

    public static function mysql(array $config): callable
    {
        return function (string $base, string $command) use ($config): void {
            self::bash(implode(' ', [$base, self::mysqlConfig($config), $command]));
        };
    }

    private static function bash(string $command): void
    {
        echo "$command\n";
        Executor::execute($command);
    }


    private static function mysqlConfig(array $database): string
    {
        return sprintf("-h'%s' -u'%s' -p'%s'", $database['host'], $database['user'], $database['password']);
    }

}