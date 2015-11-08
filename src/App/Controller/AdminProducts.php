<?php

namespace App\Controller;

use App\DB\ProductRepository;
use Silex\Application;

class AdminProducts
{	
	private $ProductRepository;

	private $app;

	function __construct(ProductRepository $ProductRepository,Application $app)
	{
		$this->ProductRepository = $ProductRepository;
		$this->app = $app;
	}


	public function show()
	{
		$products = $this->ProductRepository->getProductsAdmin();
		return $this->renderShow($products);
	}

	public function edit($id)
	{
		if (count($_POST) > 0) {
			$changes = $_POST;
			foreach ($changes as $key => $value) {
				$changes[$key] = htmlspecialchars($value);
			}
			$changes['id'] = $id;
			$this->ProductRepository->changeProduct($changes);
		} else {
			$product = $this->ProductRepository->getProduct($id);
			setcookie('edit_id', $id, time() + 3600);
			return $this->renderEdit($product);
		}
	}

	public function delete($id)
	{
		$this->ProductRepository->deleteProduct($id);
	}

	public function add()
	{
		if (count($_POST) > 0) {
			$product = $_POST;
			foreach ($product as $key => $value) {
				$changes[$key] = htmlspecialchars($value);
			}
			$this->ProductRepository->addProduct($product);
		} else {
			return $this->renderAdd();
		}
	}

	protected function renderShow($products)
	{ 
	    return $this->app['twig']->render('admin/products.twig', [
			'products' => $products			
    	]);
	}

	protected function renderEdit($product)
	{ 
	    return $this->app['twig']->render('admin/products/edit.twig', [
			'product' => $product			
    	]);
	}

	protected function renderAdd()
	{ 
	    return $this->app['twig']->render('admin/products/add.twig');
	}

}