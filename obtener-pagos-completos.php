<?php
// Iniciamos las llaves de OpenPay
include("datos-conexion-openpay.php");

// Agregamos el post para los json
/*$_POST = json_decode(file_get_contents('php://input'), true);
$cliente_id = $_POST['cliente_id'];*/

require(dirname(__FILE__) . '/openpay-php/Openpay.php');


try {
	// Agregamos las keys para las librerís de 
	$openpay = Openpay::getInstance($id_openpay, $sk_openpay);

	$findDataRequest = array('offset' => 0, 'limit' => 100000000);
	$customerList = $openpay->customers->getList($findDataRequest);

	$findDataRequest = array('offset' => 0, 'limit' => count($customerList));
	$array1;
	$array2;
	for ($i=0; $i < count($customerList); $i++) { 
		$customer = $openpay->customers->get($customerList[$i]->id);
		if ($i === 0) {
			$array1 = $chargeList = $customer->charges->getList($findDataRequest);
		}else{
			$array2 = $chargeList = $customer->charges->getList($findDataRequest);
			$array1 = array_merge($array1, $array2);
		}		
	}
	for ($i=0; $i < count($array1); $i++) { 
		$data[] = array(
			$array1[$i]->id, 
			$array1[$i]->status, 
			$array1[$i]->amount, 
			$array1[$i]->description, 
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
