<?php

namespace App\Controller;

use App\DB\ProductRepository;
use Silex\Application;

class Main
{
	private $ProductRepository;
	private $app;

	function __construct(ProductRepository $ProductRepository, Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->app = $app;
	}

	public function page()
	{
		$products = $this->ProductRepository->getProducts();
		return $this->render($products); 
	}

	protected function render($products)
	{
        return $this->app['twig']->render('main/page.twig', [
			'products' => $products
    	]);
	}
}