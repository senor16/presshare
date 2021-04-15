<?php 

define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
define('ROOT_URL','http://localhost/php/presshare/');

require_once ROOT."vendor/autoload.php";


use App\Controllers\Errors;
	
	

$params = strtolower($_GET['p']);
//require_once (ROOT.'app/controllers/Errors.php');
$error = new Errors();

$params = explode('/',$params);

$controller =$params[0]!= ''? ucfirst($params[0]) : 'Home';


$file= ROOT.'Controllers/'.$controller.'.php';
if(file_exists($file)){
//	require_once (ROOT.'controllers/'.$controller.'.php');			
	$controller = "App\\Controllers\\".$controller;	 	
	$action = isset($params[1]) ? $params[1] : 'index';
	if(class_exists($controller)){		
		$controller = new $controller;
		$action = isset($params[1]) ? $params[1] : 'index';
		if(method_exists($controller, $action)){
			unset($params[0]);
			unset($params[1]);
			call_user_func_array([$controller,$action], $params);			
		}else{

			$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);
		}
	}else{
		$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);
	}
}else{
	$error->render('errors',['code'=>404, 'message'=>'La page demandée n\'existe pas']);			
}


