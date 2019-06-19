<?php 

$request = $_SERVER['REQUEST_URI'];
	
	$url = parse_url($_SERVER['REQUEST_URI']);
	if ($url != '/') {
     $path = $url['path'];
	 }
	     
	if($request == '/rest/' || ($request == '/')) {
		require __DIR__ . '/index.php';
	} else if( $request == '/rest/index'){
		 require  'product/read.php';	
	} else if( $path == '/rest/index' && !empty($_GET['id'])){
		 require  'product/read_one.php';
	} else if( $path == '/rest/index' && !empty($_GET['s'])){
		 require  'product/search.php';		
	} else {
		 require __DIR__ . '/views/404.php';
	}
	
	
		



?>