<?php

namespace App\Controller;

use Silex\Application;
use App\Controller\Cart;

class Header
{
	private $app;
	private $cart;

	function __construct(Cart $cart,Application $app)
	{
		$this->app = $app;
		$this->cart = $cart;
	}

	public function page()
	{
		$in_cart = $this->cart->inCart();
		if (isset($_SESSION['username'])) {
			$user = true;
		} else {
			$user = false;
		}
		return $this->render($in_cart, $user); 
	}

	protected function render($in_cart, $user)
	{
        return $this->app['twig']->render('header/header.twig', [
			'in_cart' => $in_cart,
			'user' => $user
    	]);
	}
}