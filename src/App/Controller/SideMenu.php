<?php

namespace App\Controller;

use App\DB\CatalogRepository;
use Silex\Application;

class SideMenu
{
	private $CatalogRepository;
	private $app;
	
	function __construct(CatalogRepository $CatalogRepository, Application $app)
	{
		$this->CatalogRepository = $CatalogRepository;
		$this->app = $app;
	}

	public function page()
	{
		$category_names = $this->CatalogRepository->getCategoryNames();
		return $this->render($category_names);
	}

	protected function render($category_names)
	{ 
		if (isset($_COOKIE['category'])) {
			$category = $_COOKIE['category'];
		} else {
			$category = null;
		}
		if (isset($_COOKIE['now'])) {
			$now = $_COOKIE['now'];
		} else {
			$now = null;
		}
	    return $this->app['twig']->render('side_menu/side_menu.twig', [
			'names' => $category_names,
			'category' => $category,
			'now' => $now
    	]);
	}
}