<?php

namespace App\Controller;

use App\DB\OrderRepository;
use Silex\Application;

class AdminOrders
{	
	private $OrderRepository;

	private $app;

	function __construct(OrderRepository $OrderRepository,Application $app)
	{
		$this->OrderRepository = $OrderRepository;
		$this->app = $app;
	}

	public function show()
	{
	    $orders = $this->OrderRepository->getOrders();
	    return $this->renderShow($orders);
	}	

	public function details($id)
	{
		$order = $this->OrderRepository->getOrder($id);
		$products = $this->OrderRepository->getProductsByOrder($id);
		$total = 0;
		foreach ($products as $key => $value) {
			$total += $value['price'] * $value['quantity'];
		}
	    return $this->renderDetails($order, $products, $total);
	}	

	protected function renderShow($orders)
	{ 
	    return $this->app['twig']->render('admin/orders.twig', [
			'orders' => $orders			
    	]);
	}

	protected function renderDetails($order, $products, $total)
	{ 
	    return $this->app['twig']->render('admin/orders/details.twig', [
			'order' => $order,
			'products' => $products,
			'total' => $total			
    	]);
	}


}