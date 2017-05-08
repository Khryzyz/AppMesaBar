<?php

$server = "ceindetec15";
$user = "admin";
$pass = "Ceidentec1*.";
$bd = "apprestaurante";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass, $bd) or die("Ha sucedido un error inexperado en la conexion de la base de datos");

/*
$username = "super3";
$password = "hiper";
$primer_nombre = "duper";
$primer_apellido = "mega";
$celular = "333";
$telefono = "666";
$tusuario_id = "1";
*/

/*
@$username = $_POST["username"];
@$password = $_POST["password"];
@$primer_nombre = $_POST["primer_nombre"];
@$primer_apellido = $_POST["primer_apellido"];
@$celular = $_POST["celular"];
@$telefono = $_POST["telefono"];
@$tusuario_id = $_POST["tusuario_id"];

@$sql_query = "insert into apprestaurante.usuario (username,password,primer_nombre,primer_apellido, celular,telefono,tusuario_id)" .
    " values('$username','$password','$primer_nombre','$primer_apellido','$celular','$telefono','$tusuario_id');";

//echo $sql_query;

@mysqli_query($conexion, $sql_query);

//echo mysqli_insert_id($conexion);


//$id=7;
$id = $_POST['id'];

//echo $id;

//generos la consulta
$sql = "SELECT * FROM apprestaurante.usuario where id= ".$id;
*/
$sql = "SELECT * FROM apprestaurante.usuario; ";
mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if (!$result = mysqli_query($conexion, $sql)) die();

$usuario = array(); //creamos un array

while ($row = mysqli_fetch_array($result)) {
    $username = $row['username'];
    $primer_nombre = $row['primer_nombre'];
    $primer_apellido = $row['primer_apellido'];

    $usuario[] = array('titulo' => $username, 'descripcion' => $primer_nombre, 'imagen' => "/img/social1.png");

}

//desconectamos la base de datos
$close = mysqli_close($conexion)
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

$items = array('items' => $usuario);

$json_string = json_encode($items);

echo $json_string;
?>

