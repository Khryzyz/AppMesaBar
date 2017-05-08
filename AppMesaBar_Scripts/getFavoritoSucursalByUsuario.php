<?php

require_once "DB_CONNECTIONS.php";

$idSucursal = $_POST['idSucursal'];
$idUsuario = $_POST['idUsuario'];

// $idSucursal = 4;
// $idUsuario = 1;

$sql_query = "SELECT " .
    "count(fav_id) as conteo " .
    "FROM apprestaurante.favorito " .
    "WHERE fav_sucursal_id = " . $idSucursal . " " .
    "AND fav_usuario_id = " . $idUsuario . " " .
    "AND fav_estado_id = 1; ";

// echo $sql_query."<br>";

if (!$result = mysqli_query($conexion, $sql_query)) die();
$statusFavorito = array();
$row = mysqli_fetch_array($result);
if ($row['conteo'] == 0)
    $statusFavorito [] = array('favorito' => 'false');
else
    $statusFavorito [] = array('favorito' => 'true');

//desconectamos la base de datos
$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$dataFavorito = array('infoFavorito' => $statusFavorito);

$json_string = json_encode($dataFavorito);

echo $json_string;
?>

