<?php

namespace MyApp\Product;


class Product {
 
    // database connection and table name
    private $_db_mysql;
    private $table_name = "products";
	private $table_name1 = "product_stock";
    // object properties
    public $id;
    public $name;
	public $lang;
	public $product_id;
    public $description;
    public $price;
	public $stock;
	public $language_id;
    public $category_id;
    public $category_name;
	public $product_date;
    public $created;
	public $modified;
 
    // constructor with $db as database connection
    public function __construct($db){
		$this->conn = $db;
		}
	
	// read products
	function read(){
	 
		// select all query
		$query = "SELECT c.name as category_name, lg.name as language_name ,p.id, p.name, p.description, ps.price, 
		ps.stock, p.category_id, p.language_id, p.created FROM products p 
		LEFT JOIN product_stock ps ON p.id = ps.product_id
		LEFT JOIN categories c ON p.category_id = c.id 
		LEFT JOIN language as lg ON p.language_id = lg.id ORDER BY p.created DESC";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create product
	function create(){
 
    // query to insert record
	$query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name,description=:description,language_id=:language_id,category_id=:category_id,created=:created,modified=:modified";
	
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
	$this->language_id=htmlspecialchars(strip_tags($this->language_id));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));
	$this->modified=htmlspecialchars(strip_tags($this->modified));
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":description", $this->description);
	$stmt->bindParam(":language_id", $this->language_id);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);
	$stmt->bindParam(":modified", $this->modified);
    // execute query
    if($stmt->execute()){
	$query = "INSERT INTO " . $this->table_name1 . " SET product_id=:product_id,price=:price,stock=:stock";
		
	 // prepare query
    $stmt1 = $this->conn->prepare($query);
	$this->product_id = $this->conn->lastInsertId();
	$this->price=htmlspecialchars(strip_tags($this->price));
	$this->stock=htmlspecialchars(strip_tags($this->stock));
	
	$stmt1->bindParam(":product_id", $this->product_id);
    $stmt1->bindParam(":price", $this->price);
	$stmt1->bindParam(":stock", $this->stock);
	if($stmt1->execute()){
		return true;
		}	
	//return true;
    }
 
    return false;
	}		
	
	function getProductLang() {

	// query to read single record
    $query = "SELECT p.id, c.name as category_name, p.name, p.description, ps.price, ps.stock ,p.category_id, p.created, p.language_id, lg.name as language_name FROM " . $this->table_name . " p 
	LEFT JOIN product_stock ps ON p.id = ps.product_id
	LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN language lg ON p.language_id = lg.id WHERE lg.name = ? LIMIT 0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->lang);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
	
    // set values to object properties
	$this->id = $row['id'];
    $this->name = $row['name'];
    $this->price = $row['price'];
	$this->stock = $row['stock'];
    $this->description = $row['description'];
	$this->language_id = $row['language_id'];
	$this->language_name = $row['language_name'];
    $this->category_id = $row['category_id'];
	$this->category_name = $row['category_name'];
}
	
	 
	 
	function readOne(){
 
    // query to read single record
    $query = "SELECT c.name as category_name, p.id, p.name, p.description, ps.price, ps.stock ,p.category_id, p.created, p.language_id, lg.name as language_name FROM " . $this->table_name . " p 
	LEFT JOIN product_stock ps ON p.id = ps.product_id
	LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN language lg ON p.language_id = lg.id WHERE p.id = ? LIMIT 0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(\PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
	$this->stock = $row['stock'];
    $this->description = $row['description'];
	$this->language_id = $row['language_id'];
	$this->language_name = $row['language_name'];
    $this->category_id = $row['category_id'];
	$this->category_name = $row['category_name'];
}

// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                description = :description,
				language_id = :language_id,
                category_id = :category_id
				
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
	$this->language_id=htmlspecialchars(strip_tags($this->language_id));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
	$stmt->bindParam(':language_id', $this->language_id);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
		
		$query = "UPDATE
                " . $this->table_name1 . "
            SET
                price = :price,
                stock = :stock,
				date = :date
				
            WHERE
                product_id = :product_id";
		
		$stmt1 = $this->conn->prepare($query);
		
		//$this->product_id = $this->conn->lastInsertId();
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->stock=htmlspecialchars(strip_tags($this->stock));
		$this->product_date=htmlspecialchars(strip_tags($this->product_date));	
		
		$stmt1->bindParam(":price", $this->price);
		$stmt1->bindParam(":stock", $this->stock);
		$stmt1->bindParam(":date", $this->product_date);
		$stmt1->bindParam(":product_id", $this->id);
		
	if($stmt1->execute()){
		return true;
		}	
		}
 
    return false;
}

// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE name = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->name);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}


// search products
function search($keywords){
 
    // select all query
     $query = "SELECT c.name as category_name, p.id, p.name, p.description, ps.stock, ps.price, p.category_id, p.created, p.language_id
            FROM " . $this->table_name . " p
                LEFT JOIN product_stock ps ON p.id = ps.product_id
				LEFT JOIN
                    categories c
                        ON p.category_id = c.id
				LEFT JOIN 
					 language as lg 
					 ON p.language_id = lg.id
            WHERE
                p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
            ORDER BY
                p.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// read products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.stock, p.language_id p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
				LEFT JOIN language lg ON p.language_id = lg.id		
            ORDER BY p.created DESC
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

// used for paging products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


}