<?php

require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'dbname' => 'duck_store_final',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ),
));

include_once __DIR__.'/../src/App/Router/router.php';

$app->run(); 