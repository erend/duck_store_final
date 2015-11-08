<?php

namespace App\Controller;

use App\DB\ProductRepository;
use App\DB\OrderRepository;
use Silex\Application;

class Order
{	
	private $ProductRepository;
	private $OrderRepository;
	private $app;

	function __construct(ProductRepository $ProductRepository, OrderRepository $OrderRepository, Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->OrderRepository = $OrderRepository;
		$this->app = $app;
	}

	public function order()
	{
		$list = $_COOKIE['products'];
		$total = 0;
		foreach ($list as $key => $value) {
			$products[$key] = $this->ProductRepository->getProduct($key);
			$total += $products[$key]['price'] * $value;
		}
		return $this->render($total);
	}

	public function completeOrder()
	{
		$list = $_COOKIE['products'];
		$details['fio'] = htmlspecialchars($_POST['fio']);
		$details['address'] = htmlspecialchars($_POST['address']);
		$details['email'] = htmlspecialchars($_POST['email']);
		$details['comment'] = htmlspecialchars($_POST['comment']);
		$this->OrderRepository->saveOrder($details, $list);

		foreach ($_COOKIE['products'] as $key => $value) {
			setcookie('products['.$key.']', $value, time() - 100);
		}
		
		return $this->renderComplete();
	}

	protected function render($total)
	{ 
	    return $this->app['twig']->render('order/page.twig', [
			'total' => $total			
    	]);
	}

		protected function renderComplete()
	{ 
	    return $this->app['twig']->render('order/complete.twig');
	}

}