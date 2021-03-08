<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Core\Database\DatabaseConnector;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

$config = new PhpFile('migrations.php');
$entityManager = DatabaseConnector::getEntityManager();

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
