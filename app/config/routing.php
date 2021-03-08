<?php

declare(strict_types=1);

use App\Controller\Controller;
use App\Controller\Transaction\TransactionController;
use Core\Router\Router;

$router = new Router();
$router->addRoute('GET', '/', Controller::class, 'index');
$router->addRoute('POST', '/transactions', TransactionController::class, 'transactions');
$router->addRoute('GET', '/newTransaction', TransactionController::class, 'newTransaction');

return $router;