<?php 
 /**Project:     Product
 * File:        Rest.class
 * Klasa odpowiedzialna za polaczenie przez Rest api z systemem
 *
 * @copyright 2019
 * @version   2.3.1
 */
 
 
 
 
	 // required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	
    
	include_once 'objects/product.php';
	include_once 'config/database.php';
	
	 $table_name = 'products';
	 
	// instantiate database and product object
	$database = new Database();
	$db = $database->getConnection();
	
    // initialize object
	$product = new Product($db);
	
	
	
	
 