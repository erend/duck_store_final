<?php

use App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () use($app, $ProductRepository) {
	$page = new \App\Controller\Main($ProductRepository, $app);
	return $page->page();
})->bind('main');

$app->get('/info', function () use($app) {
	$page = new \App\Controller\Info($app);
	return $page->page();
})->bind('info');

$app->get('/delivery', function () use($app) {
	$page = new \App\Controller\Delivery($app);
	return $page->page();
})->bind('delivery');

$app->get('/contacts', function () use($app) {
	$page = new \App\Controller\Contacts($app);
	return $page->page();
})->bind('contacts');

$app->get('/product/{id}', function($id) use($app, $ProductRepository) { 
	$page = new \App\Controller\Product($ProductRepository, $app);
	return $page->page($id);	
})->bind('show_product');

$app->get('/category/{id}', function($id) use($app, $CatalogRepository) { 
	$page = new \App\Controller\Catalog($CatalogRepository, $app);
	return $page->page($id);	
})->bind('show_category');

$app->get('/header', function () use($app, $ProductRepository) {
	$cart = new \App\Controller\Cart($ProductRepository, $app);
	$page = new \App\Controller\Header($cart, $app);
	return $page->page();
})->bind('header');

$app->get('/side_menu', function () use($app, $CatalogRepository) {
	$page = new \App\Controller\SideMenu($CatalogRepository, $app);
	return $page->page();	
})->bind('side_menu');

$app->get('/add_to_cart/{product_id}', function ($product_id) use($app, $ProductRepository) {
    $cart = new \App\Controller\Cart($ProductRepository, $app);
    $cart->add($product_id);
	return $app->redirect('/');;
})->bind('add_to_cart');

$app->get('/cart/{in_cart}', function ($in_cart) use($app, $ProductRepository) {
	$page = new \App\Controller\Cart($ProductRepository, $app);
	return $page->page($in_cart);	
})->bind('cart');

$app->get('/order', function () use($app, $ProductRepository, $OrderRepository) {
	$page = new \App\Controller\Order($ProductRepository, $OrderRepository, $app);
	return $page->order();	
})->bind('order');

$app->post('/complete_order', function () use($app, $ProductRepository, $OrderRepository) {
	$page = new \App\Controller\Order($ProductRepository, $OrderRepository, $app);
	return $page->completeOrder();	
})->bind('complete_order');

$app->get('/login/{state}', function ($state) use($app, $UserRepository) {
	$page = new \App\Controller\Login($UserRepository, $app);
	return $page->page($state);	
})->bind('login_get');

$app->post('/login', function () use($app, $UserRepository) {
	$login = new \App\Controller\Login($UserRepository, $app);
    if ($login->validate()) {
    	return $app->redirect('/admin');
    } else {
		return $app->redirect('/login/error');
    }	
})->bind('login_post');

$app->get('/admin', function () use($app) {
	$page = new \App\Controller\Admin($app);
	return $page->page();	
})->bind('admin');

$app->get('/admin_products/show', function () use($app, $ProductRepository) {
	$page = new \App\Controller\AdminProducts($ProductRepository, $app);
	return $page->show();	
});

$app->get('/admin_products/add', function () use($app, $ProductRepository) {
	$page = new \App\Controller\AdminProducts($ProductRepository, $app);
	return $page->add();	
});

$app->post('/admin_products/add', function () use($app, $ProductRepository) {
	$add = new \App\Controller\AdminProducts($ProductRepository, $app);
	$add->add();
	return $app->redirect('/admin_products/show');	
});

$app->get('/admin_products/edit/{id}', function ($id) use($app, $ProductRepository) {
	$page = new \App\Controller\AdminProducts($ProductRepository, $app);
	return $page->edit($id);	
});

$app->post('/admin_products/edit', function () use($app, $ProductRepository) {
	$edit = new \App\Controller\AdminProducts($ProductRepository, $app);
	$id = $_COOKIE['edit_id'];
	$edit->edit($id);
	return $app->redirect('/admin_products/show');	
});

$app->get('/admin_products/delete/{id}', function ($id) use($app, $ProductRepository) {
	$delete = new \App\Controller\AdminProducts($ProductRepository, $app);
	$delete->delete($id);	
	return $app->redirect('/admin_products/show');	
});                                                                                       // -------------------------

$app->get('/admin_categories/show', function () use($app, $CatalogRepository) {
	$page = new \App\Controller\AdminCategories($CatalogRepository, $app);
	return $page->show();	
});

$app->get('/admin_categories/add', function () use($app, $CatalogRepository) {
	$page = new \App\Controller\AdminCategories($CatalogRepository, $app);
	return $page->add();	
});

$app->post('/admin_categories/add', function () use($app, $CatalogRepository) {
	$add = new \App\Controller\AdminCategories($CatalogRepository, $app);
	$add->add();
	return $app->redirect('/admin_categories/show');	
});

$app->get('/admin_categories/edit/{id}', function ($id) use($app, $CatalogRepository) {
	$page = new \App\Controller\AdminCategories($CatalogRepository, $app);
	return $page->edit($id);	
});

$app->post('/admin_categories/edit', function () use($app, $CatalogRepository) {
	$edit = new \App\Controller\AdminCategories($CatalogRepository, $app);
	$id = $_COOKIE['edit_id'];
	$edit->edit($id);
	return $app->redirect('/admin_categories/show');	
});

$app->get('/admin_categories/delete/{id}', function ($id) use($app, $CatalogRepository) {
	$delete = new \App\Controller\AdminCategories($CatalogRepository, $app);
	$delete->delete($id);	
	return $app->redirect('/admin_categories/show');	
});

$app->get('/admin_orders/show', function () use($app, $OrderRepository) {
	$page = new \App\Controller\AdminOrders($OrderRepository, $app);
	return $page->show();	
});

$app->get('/admin_orders/details/{id}', function ($id) use($app, $OrderRepository) {
	$page = new \App\Controller\AdminOrders($OrderRepository, $app);
	return $page->details($id);	
});








