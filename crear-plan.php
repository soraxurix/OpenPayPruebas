<?php
// Iniciamos las llaves de OpenPay
include("datos-conexion-openpay.php");

// Agregamos el post para los json
$_POST = json_decode(file_get_contents('php://input'), true);
$amount = $_POST["amount"];
$status_after_retry = $_POST["status_after_retry"];
$retry_times = $_POST["retry_times"];
$name = $_POST["name"];
$repeat_unit = $_POST["repeat_unit"];
$trial_days = $_POST["trial_days"];
$repeat_every = $_POST["repeat_every"];
$currency = $_POST["currency"];

// Añadimos la librearía php de OpenPay
require (dirname(__FILE__) . '/openpay-php/Openpay.php');

try {
	// Agregamos las keys para las librerís de 
	$openpay = Openpay::getInstance($id_openpay, $sk_openpay);
	
	$planData = array(
		'amount' => $amount,
		'status_after_retry' => $status_after_retry,
		'retry_times' => $retry_times,
		'name' => $name,
		'repeat_unit' => $repeat_unit,
		'trial_days' => $trial_days,
		'repeat_every' => $repeat_every,
		'currency' => $currency);

	$plan = $openpay->plans->add($planData);

	 // echo json_encode($plan->id);
	 agregar_plan_BD($plan);

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

function agregar_plan_BD ($plan){
	include("consultas/connection.php");
	$consulta = "INSERT INTO `Planes` VALUES('$plan->id', '$plan->name', '$plan->amount', '$plan->repeat_every', '$plan->repeat_unit', '$plan->retry_times','$plan->status_after_retry', '$plan->trial_days')";
	$result = mysqli_query($con, $consulta);
	// // Validamos si la consulta se ejecute correctamente, si no se ejecuta reotrnamos un mensaje de error.
	if ($result) {
		echo json_encode(200);
	}else{
		echo json_encode(201);
	}
}
?>
