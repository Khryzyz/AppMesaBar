<?php
	
	require_once "DB_CONNECTIONS.php";
	
	//$idSucursal = $_POST['idSucursal'];
	$idSucursal=3;
	
	$sql_query =	
	"SELECT ".
	"meSuc.id AS idMenuSucursal, ".
	"men.nombre AS nombreMenuSucursal, ". 
	"men.descripcion AS descripcionMenuSucursal, ". 
	"cat.nombre AS nombreCategoria ".
	"FROM apprestaurante.menu_sucursal meSuc ".
	"INNER JOIN apprestaurante.sucursal suc ON suc.id=meSuc.sucursal_id ".
	"INNER JOIN apprestaurante.menu men ON men.id = meSuc.menu_id ".
	"INNER JOIN apprestaurante.menu_categoria meCat ON meCat.menu_id = men.id ".
	"INNER JOIN apprestaurante.tcategoria cat ON meCat.categoria_id = cat.id ".
	"WHERE meSuc.sucursal_id = ".$idSucursal." AND meSuc.estado_id=1";
	
	//echo $sql_query."<br>";
	
	
	if (!$result = mysqli_query($conexion, $sql_query)) die();
	
	$auxIdMenuSucursal=0;
	$contadorMenu=0;
	
	$row = mysqli_fetch_array($result);
	for ($i=0;$i<mysqli_num_rows($result);$i++)
	{
		if ($auxIdMenuSucursal!=$row['idMenuSucursal']){
			
			$auxIdMenuSucursal=$row['idMenuSucursal'];
			
			$idMenuSucursal = $row['idMenuSucursal'];
			$nombreMenuSucursal = $row['nombreMenuSucursal'];
			$descripcionMenuSucursal = $row['descripcionMenuSucursal'];
			$nombreCategoria[$contadorMenu] = $row['nombreCategoria'];
		}
		else{
			$nombreCategoria[$contadorMenu] = $row['nombreCategoria'];
		}
		
		$contadorMenu++;
		
		$row = mysqli_fetch_array($result);
		if($auxIdMenuSucursal!=$row['idMenuSucursal']){
			$infoMenuSucursal []= array(
			'idMenuSucursal' => $idMenuSucursal,
			'nombreMenuSucursal' => $nombreMenuSucursal,
			'descripcionMenuSucursal' => $descripcionMenuSucursal,
			'nombreCategoria1' => isset($nombreCategoria[0]) ? $nombreCategoria[0]: NULL,
			'nombreCategoria2' => isset($nombreCategoria[1]) ? $nombreCategoria[1]: NULL,
			'nombreCategoria3' => isset($nombreCategoria[2]) ? $nombreCategoria[2]: NULL,
			'nombreCategoria4' => isset($nombreCategoria[3]) ? $nombreCategoria[3]: NULL,
			'nombreCategoria5' => isset($nombreCategoria[4]) ? $nombreCategoria[4]: NULL,
			);
			$contadorMenu=0;
		}
		
	}
	
	//desconectamos la base de datos
	$close = mysqli_close($conexion) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
	
	$comentariosSucursalData = array('infoMenuSucursal' => $infoMenuSucursal);
	
	$json_string = json_encode($comentariosSucursalData);
	
	echo $json_string;
?>

