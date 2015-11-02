<?php

require_once __DIR__.'/../vendor/autoload.php'; 

require_once __DIR__.'/../src/autoload.php'; 

use App\DB;

session_start();

$app = new Silex\Application(); 
$app['debug'] = true;

require_once __DIR__.'/../src/App/Silex_init/init.php'; 

$Connection = new DB\Connection();
$ProductRepository = new DB\ProductRepository($Connection);
$CatalogRepository = new DB\CatalogRepository($Connection);
//$UserRepository = new DB\UserRepository($Connection);
//$OrderRepository = new DB\OrderRepository($Connection);

require_once __DIR__.'/../src/App/Router/router.php';

$app->run(); 
