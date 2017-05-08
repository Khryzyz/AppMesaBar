<?php

require_once "DB_CONNECTIONS.php";

$idSucursal = $_POST['idSucursal'];
$idUsuario = $_POST['idUsuario'];
$tituloComentario = $_POST['tituloComentario'];
$textoComentario = $_POST['textoComentario'];
$puntajeComentario = $_POST['puntajeComentario'];

$sql_query =
    "INSERT  apprestaurante.puntuacion(sucursal_id,usuario_id,titulo_comentario,texto_comentario,puntuacion,fecha,hora)" .
    "VALUES(" . $idSucursal . "," . $idUsuario . ",'" . $tituloComentario . "','" . $textoComentario . "'," . $puntajeComentario . ",CURDATE(),CURTIME())";

// echo $sql_query."<br>";

if (!$result = mysqli_query($conexion, $sql_query)) {
    //Codigo usado en la aplicacion= ERROR_INSERT: error en la insercion del favorito
    $statusComentario [] = array('codigo' => 'ERROR_INSERT', 'mensaje' => 'favorito_error', 'estado' => '1');
} else {

    if (mysqli_insert_id($conexion) > 0) {
        //Codigo usado en la aplicacion= OK: insercion del favorito completa
        $statusComentario [] = array('codigo' => 'OK_INSERT', 'mensaje' => 'comentario_agregado');
    } else {
        //Codigo usado en la aplicacion= NO_INSERT: insercion del favorito no se completo
        $statusComentario [] = array('codigo' => 'NO_INSERT', 'mensaje' => 'comentario_no_agregado');
    }
}

//desconectamos la base de datos
$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$dataComentario = array('insercionComentarioSucursal' => $statusComentario);

$json_string = json_encode($dataComentario);

echo $json_string;

?>

