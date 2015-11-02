<?php

namespace App\DB;

class CatalogRepository
{

	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection->getConnection();
	}

	public function getProductsForCategory($categoryId)
	{ 
	    $sql = "SELECT * FROM `products` AS p 
				    INNER JOIN `item_img` AS i 
				        ON p.`id` = i.`product_id` 
				WHERE `category_id` = :id";
	    $stmt = $this->connection->prepare($sql);
	    $stmt->bindParam(':id', $categoryId);
	    $stmt->execute();
	    return $stmt->fetchAll(\PDO::FETCH_ASSOC);		
	}
	public function getCategoryName($categoryId)
	{
	    $sql = "SELECT `title` FROM `categories` WHERE `id` = :id";
	    $stmt = $this->connection->prepare($sql);
	    $stmt->bindParam(':id', $categoryId);
	    $stmt->execute();
	    return $stmt->fetch(\PDO::FETCH_ASSOC);		
	}

}