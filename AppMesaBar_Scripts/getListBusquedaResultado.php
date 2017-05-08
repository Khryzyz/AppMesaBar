<?php
	
	require_once "DB_CONNECTIONS.php";
	
	$query = $_POST['query'];
	
	$sql_query = "SELECT suc.id AS idSucursal, AVG(pun.puntuacion) AS puntuacion, COUNT(pun.puntuacion) AS conteo, suc.nombre, cat.nombre as categoria, IFNULL(suc.latitud,0) AS latitud, IFNULL(suc.longitud,0) AS longitud ".
	"FROM apprestaurante.puntuacion as pun ".
	"INNER JOIN apprestaurante.sucursal suc ON pun.sucursal_id = suc.id ".
	"INNER JOIN apprestaurante.establecimiento est ON suc.establecimiento_id = est.id ".
	"INNER JOIN apprestaurante.tcategoria cat ON suc.categoria_id = cat.id ".
	"WHERE UPPER(suc.nombre) LIKE '%".$query ."%' OR UPPER(cat.nombre) LIKE '%".$query ."%' ".
	"GROUP BY suc.nombre ".
	"ORDER BY puntuacion DESC, conteo DESC, pun.fecha DESC;";
	
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
	
	$json_string = json_encode($topData);
	
	echo $json_string;
?>

