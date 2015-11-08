<?php

namespace App\Controller;

use App\DB\CatalogRepository;
use Silex\Application;

class AdminCategories
{	
	private $CatalogRepository;

	private $app;

	function __construct(CatalogRepository $CatalogRepository,Application $app)
	{
		$this->CatalogRepository = $CatalogRepository;
		$this->app = $app;
	}


	public function show()
	{
		$categories = $this->CatalogRepository->getCategoryNames();
		return $this->renderShow($categories);
	}

	public function edit($id)
	{
		if (count($_POST) > 0) {
			$changes = $_POST;
			foreach ($changes as $key => $value) {
				$changes[$key] = htmlspecialchars($value);
			}
			$changes['id'] = $id;
			$this->CatalogRepository->changeCategory($changes);
		} else {
			$category = $this->CatalogRepository->getCategoryName($id);
			$category['id'] = $id;
			setcookie('edit_id', $id, time() + 3600);
			return $this->renderEdit($category);
		}
	}

	public function delete($id)
	{
		$this->CatalogRepository->deleteCategory($id);
	}

	public function add()
	{
		if (count($_POST) > 0) {
			$category = $_POST;
			foreach ($category as $key => $value) {
				$changes[$key] = htmlspecialchars($value);
			}
			$this->CatalogRepository->addCategory($category);
		} else {
			return $this->renderAdd();
		}
	}

	protected function renderShow($categories)
	{ 
	    return $this->app['twig']->render('admin/categories.twig', [
			'categories' => $categories		
    	]);
	}

	protected function renderEdit($category)
	{ 
	    return $this->app['twig']->render('admin/categories/edit.twig', [
			'category' => $category			
    	]);
	}

	protected function renderAdd()
	{ 
	    return $this->app['twig']->render('admin/categories/add.twig');
	}

}