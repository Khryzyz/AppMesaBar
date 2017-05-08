<?php
	
	require_once "DB_CONNECTIONS.php";
	
	// $idSucursal = $_POST['idSucursal'];
	$idSucursal=4;
		
	$sql_query =
	"SELECT ".
	"suc.id AS idSucursal, ".
	"suc.nombre, ".	
	"AVG(pun.puntuacion) AS puntuacion, ".	
	"COUNT(pun.puntuacion) as comentarios, ".
	"bus.conteo AS busquedas, ".	
	"cat.nombre as categoria, ".
	"IFNULL(suc.latitud,0) AS latitud, ".
	"IFNULL(suc.longitud,0) AS longitud ".	
	"FROM apprestaurante.busqueda as bus ".
	"INNER JOIN apprestaurante.puntuacion as pun ON bus.sucursal_id = pun.sucursal_id ".
	"INNER JOIN apprestaurante.sucursal suc ON bus.sucursal_id = suc.id ".
	"INNER JOIN apprestaurante.establecimiento est ON suc.establecimiento_id = est.id ".
	"INNER JOIN apprestaurante.tcategoria cat ON suc.categoria_id = cat.id ".
	"WHERE suc.id = ".$idSucursal.";";
		
	// echo $sql_query;
	
	if (!$result = mysqli_query($conexion, $sql_query)) die();
	
	$topInfo = array(); //creamos un array
	
	while ($row = mysqli_fetch_array($result)) {
		
		$sucursal = $row['idSucursal'];
		$nombre = $row['nombre'];		
		$puntuacion = $row['puntuacion'];
		$comentarios = $row['comentarios'];
		$busquedas = $row['busquedas'];		
		$categoria = $row['categoria'];
		$latitud = $row['latitud'];
		$longitud = $row['longitud'];
		
		$topInfo []= array('sucursal' => $sucursal,'nombre' => $nombre, 'puntuacion' => $puntuacion ,'comentarios' => $comentarios , 'busquedas' => $busquedas ,'categoria' => $categoria,'latitud' => $latitud , 'longitud' => $longitud );
		
	}
	
	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	
	$topData = array('infoSucursal' => $topInfo);
	
	$json_string = json_encode($topData);
	
	echo $json_string;
?>

