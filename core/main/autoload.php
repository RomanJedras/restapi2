<?php 

define('DS',DIRECTORY_SEPARATOR);

      require __DIR__ . '/../../vendor/autoload.php';
	  
	  function autloader($className){
		  $className = str_replace("\\", "/", $className);
		   include_once dirname(__FILE__).'/../../'.'objects'.'/'.$className. '.class.php';
	  }
	  
	  spl_autoload_register('autloader');