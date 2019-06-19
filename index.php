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
	
	include_once  './core/main/autoload.php';
	include_once  'router.php';
	
	
	
	$table_name = 'products';
	$table_name1 = 'product_stock'; 
	// instantiate database and product object
	$database = new \myApp\databases\Databases();
	$db = $database->getConnection();
	
    // initialize object
	$product = new \myApp\product\Product($db);
	
	
	
 