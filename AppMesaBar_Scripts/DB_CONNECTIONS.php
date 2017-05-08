<?php	
	$SERVER = "ceindetec15";
	$USER = "admin";
	$PASS = "Ceidentec1*.";
	$BD = "apprestaurante";		
	$conexion = mysqli_connect($SERVER, $USER, $PASS, $BD) or die("Ha sucedido un error inexperado en la conexion de la base de datos");	
	mysqli_set_charset($conexion, "utf8"); //formato de datos utf8
?>