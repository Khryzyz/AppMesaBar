<?php
	
	require_once "DB_CONNECTIONS.php";
	
	//$request = json_decode(file_get_contents('php://input'));
	//$idCategoria = $request->idCategoria;
	
	$idCategoria = $_POST['idCategoria'];
	
	$sql_query = "SELECT nombre, id as idCategoria FROM  apprestaurante.tcategoria WHERE id = ".$idCategoria ." ; ";
	
	//echo $sql_query;
	
	if (!$result = mysqli_query($conexion, $sql_query)) die();
	
	$categoria = array(); //creamos un array
	
	while ($row = mysqli_fetch_array($result)) {
		$nombre = $row['nombre'];
		$idCategoria = $row['idCategoria'];
		
		$categoria []= array('nombre' => $nombre, 'idCategoria' => $idCategoria, );
		
	}
	
	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	
	$categoriaData = array('categoria' => $categoria);
	
	$json_string = json_encode($categoriaData);
	
	echo $json_string;
?>

