<?php

$app->get('/', function () use ($app) {
	$sql = "SELECT * FROM `products` LIMIT 6";
	$stmt = $app['db']->prepare($sql);
	$stmt->execute();
	$products = $stmt->fetchAll();
    return $app['twig']->render('main/page.twig', [
		'products' =>$products
    	]);
});

$app->get('/product/{id}', function($id) use($app) { 
	$sql = "SELECT p.id, p.title, p.description, p.price, c.title AS c_title
              FROM `products` AS p
              INNER JOIN `categories` AS c
                  ON p.`category_id` = c.`id`
              WHERE p.`id` = :id";
	$stmt = $app['db']->executeQuery($sql, [
		'id' => $id
	]);
	$product = $stmt->fetch();	
    return $app['twig']->render('_product.twig', [
		'product' =>$product
    	]);	
})->bind('show_product');
