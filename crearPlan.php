<?php
require(dirname(__FILE__) . '/openpay-php/Openpay.php');

$openpay = Openpay::getInstance('mwfanfxqufp7o9fvm3yk', 'sk_80b0b4cfda26421dac803d7d524347c8', 'MX');

$planData = array(
	'amount' => 99.00,
	'status_after_retry' => 'cancelled',
	'retry_times' => 2,
	'name' => 'Plan Prueba Progym',
	'repeat_unit' => 'month',
	'trial_days' => '30',
	'repeat_every' => '1',
	'currency' => 'MXN');

$plan = $openpay->plans->add($planData);

// $plan = $openpay->plans->get('ppb2fkwcb1ewqvraromd');



?>
