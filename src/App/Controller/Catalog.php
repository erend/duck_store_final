<?php

namespace App\Controller;

use App\DB\CatalogRepository;
use Silex\Application;
use App\Controller\Pager;

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
		setcookie('category['.$categoryId.']', true, time() + 3600);          //это для подсветки посещенных в side_menu
		setcookie('now', $categoryId, time() + 3600);
        $pager = new Pager($products);
        $page = $pager->paging(3); // количество элементов на странице

		return $this->render($products, $category_name, $categoryId, $page);
	}

	protected function render($products, $category_name, $categoryId, $page)
	{ 
	    return $this->app['twig']->render('catalog/page.twig', [
			'products' => $products,
			'category' => $category_name,
			'categoryId' => $categoryId,
			'page' => $page
    	]);
	}
}