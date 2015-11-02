<?php

use App\Controller;

$app->get('/', function () use($app, $ProductRepository) {
	$page = new \App\Controller\Main($ProductRepository, $app);
	return $page->page();
});

$app->get('/product/{id}', function($id) use($app, $ProductRepository) { 
	$page = new \App\Controller\Product($ProductRepository, $app);
	return $page->page($id);	
})->bind('show_product');

$app->get('/category/{id}', function($id) use($app, $CatalogRepository) { 
	$page = new \App\Controller\Catalog($CatalogRepository, $app);
	return $page->page($id);	
})->bind('show_category');



