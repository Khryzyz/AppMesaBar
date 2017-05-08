<?php
	require_once "DB_CONNECTIONS.php";
	$sql_query = "SELECT suc.id AS idSucursal, AVG(pun.puntuacion) AS puntuacion, MAX(bus.conteo) AS conteo, suc.nombre, cat.nombre as categoria, IFNULL(suc.latitud,0) AS latitud, IFNULL(suc.longitud,0) AS longitud ".
	"FROM apprestaurante.busqueda as bus ".
	"INNER JOIN apprestaurante.puntuacion as pun ON bus.sucursal_id = pun.sucursal_id ".
	"INNER JOIN apprestaurante.sucursal suc ON bus.sucursal_id = suc.id ".
	"INNER JOIN apprestaurante.establecimiento est ON suc.establecimiento_id = est.id ".
	"INNER JOIN apprestaurante.tcategoria cat ON suc.categoria_id = cat.id ".
	"GROUP BY suc.nombre ".	
	"ORDER BY conteo DESC, bus.fecha DESC ".
	"LIMIT 1;";

	//echo $sql_query;

	if (!$result = mysqli_query($conexion, $sql_query)) die();

	$topInfo = array(); //creamos un array

	while ($row = mysqli_fetch_array($result)) {

		$sucursal = $row['idSucursal'];
		$nombre = $row['nombre'];
		$categoria = $row['categoria'];
		$puntuacion = $row['puntuacion'];
		$latitud = $row['latitud'];
		$longitud = $row['longitud'];

		$topInfo []= array('sucursal' => $sucursal,'nombre' => $nombre, 'categoria' => $categoria, 'puntuacion' => $puntuacion , 'latitud' => $latitud , 'longitud' => $longitud );

	}

	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	
	$topData = array('infoSucursal' => $topInfo);

	$json_string = trim(json_encode($topData));
	//$json_string = json_encode(array_map(utf8_encode,stripslashes($topData)))

	echo $json_string;
?>