<?php
// Iniciamos las llaves de OpenPay
include("datos-conexion-openpay.php");

// Agregamos el post para los json
$_POST = json_decode(file_get_contents('php://input'), true);
$cliente_id = $_POST['cliente_id'];

require(dirname(__FILE__) . '/openpay-php/Openpay.php');


try {
	// Agregamos las keys para las librerís de 
	$openpay = Openpay::getInstance($id_openpay, $sk_openpay);

	$findDataRequest = array('offset' => 0);

	$customer = $openpay->customers->get($cliente_id);
	$chargeList = $customer->charges->getList($findDataRequest);

	$data = array();
	for ($i=0; $i < count($chargeList); $i++) { 
		$data[] = array(
			$chargeList[$i]->id, 
			$chargeList[$i]->status, 
			$chargeList[$i]->amount, 
			$chargeList[$i]->description, 
		);
	}
	
	echo json_encode($data);
	
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

function agregar_suscripcion ($sus, $id_tarjeta){
	include("consultas/connection.php");
	$consulta = "INSERT INTO `suscripciones` VALUES ('$sus->id', '$sus->customer_id', '$sus->plan_id', '$id_tarjeta')";
	
	$result = mysqli_query($con, $consulta);
	// Validamos si la consulta se ejecute correctamente, si no se ejecuta reotrnamos un mensaje de error.
	if ($result) {
		echo json_encode(200);
	}else{
		echo json_encode(201);
	}
}

?>
