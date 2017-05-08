<?php

	require_once "DB_CONNECTIONS.php";

	//$idSucursal = $_POST['idSucursal'];
	$idSucursal=4;

	$sql_query =
	"SELECT ".
	"usu.avatar AS avatarComentario, ".
	"IFNULL(pun.titulo_comentario,'') AS tituloComentario, ".
	"IFNULL(pun.texto_comentario,'') AS textoComentario, ".
    "IFNULL(pun.puntuacion,'3.0') AS puntuacionComentario, ".
    "IFNULL(pun.fecha,CURDATE()) AS fechaComentario, ".
    "IFNULL(pun.hora,CURTIME()) AS horaComentario ".
	"FROM apprestaurante.puntuacion pun ".
	"INNER JOIN apprestaurante.usuario usu ON usu.id=pun.usuario_id ".
	"WHERE pun.sucursal_id = ".$idSucursal." AND pun.estado_id=1";

	// echo $sql_query;

	if (!$result = mysqli_query($conexion, $sql_query)) die();

	$infoComentariosSucursal = array(); //creamos un array

	while ($row = mysqli_fetch_array($result)) {

		$avatarComentario = base64_encode($row['avatarComentario']);
		$tituloComentario = $row['tituloComentario'];
		$textoComentario = $row['textoComentario'];
		$puntuacionComentario = $row['puntuacionComentario'];
		$fechaComentario = $row['fechaComentario'];
		$horaComentario = $row['horaComentario'];

		$infoComentariosSucursal []= array(
			'avatarComentario' => $avatarComentario,
			'tituloComentario' => $tituloComentario,
			'textoComentario' => $textoComentario,
			'puntuacionComentario' => $puntuacionComentario,
			'fechaComentario' => $fechaComentario,
			'horaComentario' => $horaComentario
		);

	}

	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	$comentariosSucursalData = array('infoComentariosSucursal' => $infoComentariosSucursal);

	$json_string = json_encode($comentariosSucursalData);

	echo $json_string;
?>

