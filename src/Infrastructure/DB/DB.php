<?php

namespace Omatech\EditoraTools\Infrastructure\DB;

use Doctrine\DBAL\DriverManager;
use Exception;
use Symfony\Component\Dotenv\Dotenv;

class DB
{
    private static $instances = [];

    public static function connection($name)
    {
        if(!isset(self::configuration()[$name])) {
            throw new Exception('Invalid connection name.');
        }
        if(!isset(self::$instances[$name])) {
            self::$instances[$name] = DriverManager::getConnection(
                self::configuration()[$name]
            );
        }
        return self::$instances[$name];
    }

    private static function configuration()
    {
        (new Dotenv())->usePutenv()->bootEnv(dirname(__DIR__, 3).'/.env');
        return require dirname(__DIR__, 3).'/config/database.php';
    }
}
