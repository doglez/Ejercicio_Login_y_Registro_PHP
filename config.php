<?php 
define('USER', 'labs');
define('PASSWORD', 'Labs123@');
define('HOST', 'localhost');
define('DATABASE', 'db_usuarios');

try{
	$connection = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
	// echo " SE CONECTO EXITOSAMENTE";
}
catch (PDOException $e){
	 exit("Error:" . $e ->getMessage());
}

?>