<?php

require_once "DB_CONNECTIONS.php";

$auxEstado = 1;

$idSucursal = $_POST['idSucursal'];
$idUsuario = $_POST['idUsuario'];

// $idSucursal = 4;
// $idUsuario = 1;

$sql_query = "SELECT " .
    "count(fav_id) as conteo, " .
    "fav_estado_id as estado " .
    "FROM apprestaurante.favorito " .
    "WHERE fav_sucursal_id = " . $idSucursal . " " .
    "AND fav_usuario_id = " . $idUsuario . ";";

//echo $sql_query . "<br>";

$statusFavorito = array();

if (!$result = mysqli_query($conexion, $sql_query)) {
    //Codigo usado en la aplicacion= ERROR_SELECT: error en la insercion del favorito
    $statusFavorito [] = array('codigo' => 'ERROR_SELECT', 'mensaje' => 'favorito_error');
} else {
    $row = mysqli_fetch_array($result);
    if ($row['conteo'] == 0) {

        $sql_query = "INSERT INTO favorito (fav_sucursal_id,fav_usuario_id,fav_fecha_registro) VALUES(" . $idSucursal . "," . $idUsuario . ",curdate())";

        // echo $sql_query."<br>";

        if (!$result = mysqli_query($conexion, $sql_query)) {
            //Codigo usado en la aplicacion= ERROR_INSERT: error en la insercion del favorito
            $statusFavorito [] = array('codigo' => 'ERROR_INSERT', 'mensaje' => 'favorito_error', 'estado' => '1');
        } else {

            if (mysqli_insert_id($conexion) > 0) {
                //Codigo usado en la aplicacion= OK: insercion del favorito completa
                $statusFavorito [] = array('codigo' => 'OK_INSERT', 'mensaje' => 'favorito_agregado');
            } else {
                //Codigo usado en la aplicacion= NO_INSERT: insercion del favorito no se completo
                $statusFavorito [] = array('codigo' => 'NO_INSERT', 'mensaje' => 'favorito_no_agregado');
            }
        }
    } else {

        if ($row['estado'] == 1)
            $auxEstado = 2;
        else
            $auxEstado = 1;

        $sql_query = "UPDATE favorito " .
            "SET fav_estado_id = " . $auxEstado . ", " .
            "fav_fecha_edicion = curdate() " .
            "WHERE fav_sucursal_id = " . $idSucursal . " " .
            "AND fav_usuario_id = " . $idUsuario . ";";

        // echo $sql_query."<br>";

        if (!$result = mysqli_query($conexion, $sql_query)) {
            //Codigo usado en la aplicacion= ERROR_INSERT: error en la insercion del favorito
            $statusFavorito [] = array('codigo' => 'ERROR_UPDATE', 'mensaje' => 'favorito_error');
        } else {

            if (mysqli_affected_rows($conexion) > 0) {
                //Codigo usado en la aplicacion= OK: insercion del favorito completa
                $statusFavorito [] = array('codigo' => 'OK_UPDATE', 'mensaje' => 'favorito_actualizado', 'estado' => $auxEstado);
            } else {
                //Codigo usado en la aplicacion= NO_INSERT: insercion del favorito no se completo
                $statusFavorito [] = array('codigo' => 'NO_UPDATE', 'mensaje' => 'favorito_no_actualizado');
            }
        }
    }
}
//desconectamos la base de datos
$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$dataFavorito = array('infoFavorito' => $statusFavorito);

$json_string = json_encode($dataFavorito);

echo $json_string;
?>

