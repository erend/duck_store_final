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

		public function getCategoryNames()
	{
	    $sql = "SELECT * FROM `categories`
	    ORDER BY `id`";
	    $stmt = $this->connection->prepare($sql);
	    $stmt->execute();
	    return $stmt->fetchAll(\PDO::FETCH_ASSOC);		
	}

		public function changeCategory($changes)
	{
		$stmt = $this->connection->prepare(
			"UPDATE `categories` 
			SET  `title` = :title
			WHERE `id` = :id"
		);
		$stmt->execute($changes);
	}

	public function deleteCategory($id)
	{
		$stmt = $this->connection->prepare(
			"DELETE FROM `categories` WHERE id = :id"
		);
		$stmt->bindParam(":id", $id);
		$stmt->execute($changes);
		$stmt = $this->connection->prepare(
			"UPDATE `products` SET `category_id` = '0' WHERE `category_id` = :id"
		);
		$stmt->bindParam(":id", $id);
		$stmt->execute($changes);
	}

	public function addCategory($category)
	{
		$stmt = $this->connection->prepare(
			"INSERT INTO `categories` (`title`)
			 VALUES (:title)"
		);
		$stmt->execute($category);
	}

}