<?php

namespace App\Controller;

use App\DB\CatalogRepository;
use Silex\Application;

class Catalog
{
	private $CatalogRepository;
	private $app;
	
	function __construct(CatalogRepository $CatalogRepository, Application $app)
	{
		$this->CatalogRepository = $CatalogRepository;
		$this->app = $app;
	}

	public function page($categoryId)
	{
		$products = $this->CatalogRepository->getProductsForCategory($categoryId);
		$category_name = $this->CatalogRepository->getCategoryName($categoryId);
		return $this->render($products, $category_name);
	}

	protected function render($products, $category_name)
	{
	    return $this->app['twig']->render('catalog/page.twig', [
			'products' => $products,
			'category' => $category_name
    	]);
	}
}