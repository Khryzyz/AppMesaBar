<?php
	
	require_once "DB_CONNECTIONS.php";
	
	$sql_query = "SELECT nombre, id as idCategoria FROM  apprestaurante.tcategoria ORDER BY RAND() LIMIT 3; ";
	
	//echo $sql_query;
	
	if (!$result = mysqli_query($conexion, $sql_query)) die();
	
	$categoriaAleatorio = array(); //creamos un array
	
	while ($row = mysqli_fetch_array($result)) {
		$nombre = $row['nombre'];
		$idCategoria = $row['idCategoria'];
		
		$categoriaAleatorio []= array('nombre' => $nombre, 'idCategoria' => $idCategoria, );
		
	}
	
	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	
	$categoriaData = array('listAleatorio' => $categoriaAleatorio);
	
	$json_string = json_encode($categoriaData);
		
	echo $json_string;
?>

