<?php

namespace App\Controller;

use App\DB\ProductRepository;
use Silex\Application;

class Product
{
	private $ProductRepository;
	private $app;
	
	function __construct(ProductRepository $ProductRepository, Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->app = $app;
	}

	public function page($id)
	{ 
		$product = $this->ProductRepository->getProduct($id);
		return $this->render($product);

	}

	protected function render($product)
	{
	    return $this->app['twig']->render('product/page.twig', [
			'product' => $product
    	]);
	}
}