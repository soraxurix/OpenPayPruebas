<?php
// Inicializamos la base de datos
include("connection.php");

// Agregamos el post para los json
$_POST = json_decode(file_get_contents('php://input'), true);
$tabla = $_POST["tabla"];

// Realizamos la consulta
if ($tabla === "tarjetas") {
	$id_cliente = $_POST["id_cliente"];
	$consulta = "SELECT t.id_tarjeta, t.numero_tarjeta, t.nombre_propietario from tarjetas t inner join clientes c on c.id_cliente = t.id_cliente where c.id_cliente = '$id_cliente'";
}else{
	$consulta = "SELECT * from $tabla";
}

$result = mysqli_query($con, $consulta);
// // Validamos si la consulta se ejecute correctamente, si no se ejecuta reotrnamos un mensaje de error.
if ($result) {
	$data = array();
	while($row2 = mysqli_fetch_assoc($result)){
		$data[] = $row2;
	}
	echo json_encode($data);
}else{
	echo json_encode(201);
}

 ?>
