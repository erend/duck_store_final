<?php

namespace App\Controller;

use App\DB\ProductRepository;
use Silex\Application;

class Cart
{	
	private $ProductRepository;
	private $app;

	function __construct(ProductRepository $ProductRepository, Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->app = $app;
	}

	public function add($product_id)
	{
		if(isset($_COOKIE['products'][$product_id])) {
		 	$inCart = $_COOKIE['products'][$product_id] + 1;
		} else {
			$inCart = 1;
		}
		setcookie('products['.$product_id.']', $inCart, time() + 3600, '/');
	}

	public function inCart()
	{
		if (isset($_COOKIE['products']) == 0) {
			$in_cart = 0; 
		} else {
			$in_cart = 0;
			foreach ($_COOKIE['products'] as $value) {
				$in_cart += $value;								
			}
		}
		return $in_cart;
	}

	public function page($in_cart)
	{
		if ($in_cart == 0) {
			return $this->renderEmpty();
		} else {
			$list = $_COOKIE['products'];
			$total = 0;
			foreach ($list as $key => $value) {
				$products[$key] = $this->ProductRepository->getProduct($key);
				$products[$key]['quantity'] = $value;
				$total += $products[$key]['price'] * $value;
			}
			return $this->render($products, $total);
		}
	}

	protected function render($products, $total)
	{ 
	    return $this->app['twig']->render('cart/page.twig', [
			'products' => $products,
			'total' => $total
    	]);
	}

	protected function renderEmpty()
	{ 
	    return $this->app['twig']->render('cart/empty.twig');
	}

}