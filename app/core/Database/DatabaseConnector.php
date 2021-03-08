<?php

declare(strict_types=1);

namespace Core\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

class DatabaseConnector
{
    private static EntityManagerInterface $instance;

    /**
     * @throws ORMException
     */
    public static function getEntityManager(): EntityManagerInterface
    {
        if (!self::$instance instanceof EntityManagerInterface) {
            defined('SRC_DIR') || define('SRC_DIR', '/var/www/html/src/');
            $paths = [SRC_DIR.'Model/Entity/'];
            $isDevMode = false;
            $dbParams = [
                'driver' => 'pdo_pgsql',
                'host' => 'lbdbpostgres',
                'user' => 'lbdb_user',
                'password' => 'lbdb_pass',
                'dbname' => 'lbdb_db',
            ];
            $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
            self::$instance = EntityManager::create($dbParams, $config);
        }

        return self::$instance;
    }
}
