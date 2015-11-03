<?php

namespace App\Controller;

use App\DB\ProductRepository;
use App\DB\CatalogRepository;
use Silex\Application;

class Layout
{
	private $ProductRepository;
	private $CatalogRepository;
	private $app;
	private $layout

	function __construct(ProductRepository $ProductRepository, CatalogRepository $CatalogRepository, Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->CatalogRepository = $CatalogRepository;
		$this->app = $app;
	}

	public function page()
	{
		$products = $this->ProductRepository->getProducts();
		return $this->render($products); 
	}

	protected function layout($products)
	{
        $products = $this->ProductRepository->getProducts();
	}
}