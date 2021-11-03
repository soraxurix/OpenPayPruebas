<?php
// Iniciamos las llaves de OpenPay
include("datos-conexion-openpay.php");

// Agregamos el post para los json
$_POST = json_decode(file_get_contents('php://input'), true);
$idCliente = $_POST['id_cliente'];
// Añadimos la librearía php de openpay
require(dirname(__FILE__) . '/openpay-php/Openpay.php');

try {
	// Agregamos las keys para las librerís de 
	$openpay = Openpay::getInstance($id_openpay, $sk_openpay);

	$cardData = array(
	  'token_id' => $_POST["token_id"],
	  'device_session_id' => $_POST["device_session_id"]
	 );

	$customer = $openpay->customers->get($idCliente);
	$card = $customer->cards->add($cardData);

	agregar_tarjeta_BD($card);

} catch (OpenpayApiTransactionError $e) {
	echo json_encode('ERROR on the transaction: ' . $e->getMessage() . 
	      ' [error code: ' . $e->getErrorCode() . 
	      ', error category: ' . $e->getCategory() . 
	      ', HTTP code: '. $e->getHttpCode() . 
	      ', request ID: ' . $e->getRequestId() . ']', 0) ;

} catch (OpenpayApiRequestError $e) {
	echo json_encode('ERROR on the request: ' . $e->getMessage(), 0);

} catch (OpenpayApiConnectionError $e) {
	echo json_encode('ERROR while connecting to the API: ' . $e->getMessage(), 0);

} catch (OpenpayApiAuthError $e) {
	echo json_encode('ERROR on the authentication: ' . $e->getMessage(), 0);
	
} catch (OpenpayApiError $e) {
	echo json_encode('ERROR on the API: ' . $e->getMessage(), 0);
	
} catch (Exception $e) {
	echo json_encode('Error on the script: ' . $e->getMessage(), 0);
}

function agregar_tarjeta_BD ($card){
	include("consultas/connection.php");
	$consulta = "INSERT INTO `tarjetas` VALUES ('$card->id', '$card->holder_name', '$card->customer_id', '$card->card_number', '$card->expiration_month', '$card->expiration_year')";
	
	$result = mysqli_query($con, $consulta);
	// // Validamos si la consulta se ejecute correctamente, si no se ejecuta reotrnamos un mensaje de error.
	if ($result) {
		echo json_encode(200);
	}else{
		echo json_encode(201);
	}
}
?>